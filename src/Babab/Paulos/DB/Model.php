<?php
/*
 * Paulos Model interface class
 *
 * Copyright (c) 2014 Benjamin Althues <benjamin@babab.nl>
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

namespace Babab\Paulos\DB;

/**
 * @class ModelInterface
 * @brief PHP Interface for abstract base class Model
 */
interface ModelInterface
{
    public function __construct(MysqlHandler $db);
    public function isValid();
    public function printSql();
    public function printInfo();
}

/**
 * @class Model
 * @brief Object Mapper -- Abstract base class for writing Models that
 *                         will be mapped to database tables.
 *
 * It acts like most ORM's but does not handle relations and has
 * a unique DRY approach to defining model properties and interacting
 * with the exposed API.
 */
abstract class Model implements ModelInterface
{
    public $_tableName;

    private $_db;
    private $_fields = array();
    private $_validationErrors = array();

    public function __construct(MysqlHandler $db)
    {
        $this->_db = $db;
        $this->_tableName = $this->_tableName
                          ?: self::_camel2underscore(get_called_class());
        $this->_tableName = $this->_db->getPrefix() . $this->_tableName;

        $defaultOrmConf = array(
            'type' => 'varchar',
            'length' => 255,
            'null' => False,
            'blank' => False,
            'default' => Null,
            'primary_key' => False,
            'unique_key' => False,
            'auto_increment' => False,
        );

        $ormProps = array('_tableName', '_db', '_validationErrors');

        foreach ($this as $key => $conf)
            if (is_array($conf))
                $this->_fields[$key] = array_merge($defaultOrmConf, $conf);

        foreach ($this->_fields as $var => $conf)
            $this->$var = $conf['default'];
    }

    public function isValid()
    {
        foreach ($this->_fields as $var => $conf) {
            $this->_validationErrors[$var] = array();

            switch ($conf['type']) {
            case 'int':
                if (!is_int($this->$var))
                    $this->_validationErrors[$var][] = "$var is not an integer";
                break;
            }
        }

        foreach ($this->_validationErrors as $field => $errors) {
            if (!$errors)
                unset($this->_validationErrors[$field]);
        }

        if ($this->_validationErrors)
            return False;
        return True;
    }

    public function getValidationErrors()
    {
        return $this->_validationErrors;
    }

    public function printSql()
    {
        $aiFlag = False;
        $primaryKeys = array();
        $uniqueKeys = array();

        if (!isset($this->_tableName) || !$this->_tableName)
            throw new \Exception(
                'createTable error: no `_tableName` supplied for this'
            );

        $sqlStr = "CREATE TABLE IF NOT EXISTS `{$this->_tableName}` (\n\t";

        $fields = array();
        foreach ($this->_fields as $key => $conf) {
            $fields[] = self::_makeColInstruction($key, $conf);
            if ($conf['primary_key'])    $primaryKeys[] = $key;
            if ($conf['unique_key'])     $uniqueKeys[] = $key;
            if ($conf['auto_increment']) $aiFlag = True;
        }

        if ($primaryKeys)
            $fields[] = "PRIMARY KEY(`" . implode("`, `", $primaryKeys) . "`)";
        if ($uniqueKeys)
            $fields[] = "UNIQUE KEY(`" . implode("`, `", $uniqueKeys) . "`)";

        $sqlStr .= implode(",\n\t", $fields);
        $sqlStr .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $sqlStr .= $aiFlag ? " AUTO_INCREMENT=1;" : ';';
        return $sqlStr;
    }

    public function printInfo()
    {
        echo "<h1>Table: " . get_called_class() . " ($this->_tableName)</h1>\n";
        echo "<h2>Table creation SQL code</h2>\n";
        echo "<pre>{$this->printSql()}</pre><br />";
        echo "<h2>Fields configuration</h2>\n";
        foreach ($this->_fields as $key => $conf) {
            echo "<hr /><strong>$key</strong><br />\n";
            echo "<pre>";
            print_r($conf);
            echo "\n\nSQL: ";
            echo $this->_makeColInstruction($key, $conf);
            echo "</pre>\n";
        }
    }

    private static function _camel2underscore($string)
    {
        $start = 0;
        $pos = strrpos($string, '\\');
        if ($pos !== false)
            $start = $pos + 1;

        $r = strtolower(substr($string, $start, 1));
        foreach (str_split(substr($string, $start + 1)) as $c)
            $r .= ctype_upper($c) ? '_' . strtolower($c) : $c;
        return $r;
    }

    private static function _makeColInstruction($fieldName, array $conf)
    {
        $instr = "`$fieldName` ";
        switch (strtolower($conf['type'])) {
        case 'varchar':
            $instr .= "VARCHAR({$conf['length']})";
            break;
        case 'text':
            $instr .= "TEXT";
            break;
        case 'int':
            $instr .= "INT({$conf['length']})";
            break;
        case 'boolean':
            $instr .= "BOOLEAN";
            break;
        }

        if ($conf['null'])
            $instr .= " NULL";
        else
            $instr .= " NOT NULL";

        if ($conf['default'] !== Null) {
            if ($conf['default'])
                $instr .= " DEFAULT '{$conf['default']}'";
            else
                $instr .= " DEFAULT '0'";
        }

        if ($conf['auto_increment'])
            $instr .= " AUTO_INCREMENT";
        return $instr;
    }
}
