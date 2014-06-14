<?php
/*
 * Simphplist MysqlHandler
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

namespace Babab\Simphplist\DB;

/**
 * @class MysqlHandler
 * @brief MySQL Handler class
 */
class MysqlHandler
{
    /**
     * MySQLi connection handler
     */
    private $_mysqli;

    /**
     * Table prefix
     */
    private $_prefix = '';

    /**
     * String used to substiute queries with prefix
     */
    private $_prefixReplaceString = '%#PP#%';

    /**
     * Constructor for MysqlHandler
     *
     * @param \mysqli | array $mysqli_or_settings mysqli instance or
     *                                            settings array
     */
    public function __construct($mysqli_or_settings=Null)
    {
        if ($mysqli_or_settings instanceof \mysqli)
            $this->_mysqli = $mysqli_or_settings;
        elseif (is_array($mysqli_or_settings))
            $settings = $mysqli_or_settings;
        else
            throw new \Exception('error: invalid parameter, must be a mysqli '
                                . 'instance or a settings array');

        if ($settings) {
            $host = ini_get('mysqli.default_host');
            $user = ini_get('mysqli.default_user');
            $pw = ini_get('mysqli.default_pw');
            $port = ini_get('mysqli.default_port');
            $socket = ini_get('mysqli.default_socket');

            foreach ($settings as $setting => $value) {
                $setting = trim(strtolower($setting));
                if ($setting == 'prefix')
                    $this->_prefix = $value;
                else
                    $$setting = $value;
            }

            $this->_mysqli = new \mysqli($host, $user, $pw, $name,
                                         $port, $socket);
        }

        if ($this->_mysqli->connect_error) {
            throw new \Exception(
                ': Connect error: '
                . $this->_mysqli->connect_error
                . ' (' . $this->_mysqli->connect_errno . ')'
            );
        }
    }

    /**
     * Execute query after substituting prefix
     *
     * @param string $query Query string (optionally prefixed with
     *                      $this->_prefixReplaceString)
     * @return \mysqli::query Query result
     */
    public function query($query)
    {
        $q = $this->_replacePrefix($query);
        # TODO: Error handling
        return $this->_mysqli->query($q);
    }

    /**
     * Execute query after substituting prefix; Alias for this::query()
     *
     * @param string $query Query string (optionally prefixed with
     *                      $this->_prefixReplaceString)
     * @return \mysqli::query Query result
     */
    public function q($query)
    {
        return $this->query($query);
    }

    /**
     * Execute a query and return results as a (multi-dimensonal)
     * associative array
     *
     * @param string $query Query string (optionally prefixed with
     *                      $this->_prefixReplaceString)
     * @param bool $order Sort results
     * @param bool $reverse_order Reverse sort results
     *
     * @return array
     */
    public function qfetch($query, $order=False, $reverse_order=False)
    {
        $result = $this->query($query);

        $retRows = array();
        if ($reverse_order) {
            for ($i = $result->num_rows - 1; $i >= 0; $i--) {
                $result->data_seek($i);
                $retRows[] = $result->fetch_assoc();
            }
            return $r;
        }

        if ($order)
            $result->data_seek(0);

        while ($row = $result->fetch_assoc())
            $retRows[] = $row;
        return $retRows;
    }

    public function setPrefix($prefix)
    {
        if (ctype_alnum($prefix))
            $this->_prefix = $prefix;
        else
            throw new \Exception('error: prefix must be alphanumerical');
    }

    public function getPrefix()
    {
        return $this->_prefix;
    }

    public function setPrefixReplaceString($prefixReplaceString)
    {
        if (ctype_alnum($prefixReplaceString))
            $this->_prefixReplaceString = $prefixReplaceString;
        else
            throw new \Exception(
                'error: prefixReplaceString must be alphanumerical'
            );
    }

    public function close()
    {
       $this->_mysqli->close();
    }

    public function info()
    {
       return $this->_mysqli->host_info;
    }

    private function _replacePrefix($string)
    {
        return str_replace($this->_prefixReplaceString, $this->_prefix,
                           $string);
    }
}
