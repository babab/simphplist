<?php
/*
 * Simphplist Debug
 *
 * Copyright (c) 2014-2015 Benjamin Althues <benjamin@babab.nl>
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

namespace Simphplist\Simphplist;

class Debug
{
    public static $debug = false;
    public static $file = '/tmp/simphplist-debug.log';
    public static $tags = ['<pre>', '</pre>'];

    public static function text() # variable argument list
    {
        if (!self::$debug)
            return false;

        if (!$n_args = func_num_args())
            return 'Debug::text(): Please pass one or more variables';

        $str = '';
        $a_args = func_get_args();
        for ($i = 0; $i < $n_args; $i++) {
            if (!self::override($a_args[$i], 'text'))
                $str .= self::dump($a_args[$i]);
        }
        echo $str;
    }

    public static function html() # variable argument list
    {
        if (!self::$debug)
            return;

        if (isset(self::$tags[0]) && self::$tags[0])
            echo self::$tags[0];

        if (!$n_args = func_num_args())
            return 'Debug::html(): Please pass one or more variables';

        $str = '';
        $a_args = func_get_args();
        for ($i = 0; $i < $n_args; $i++) {
            if (!self::override($a_args[$i], 'html'))
                $str .= self::dump($a_args[$i]);
        }
        echo $str;

        if (isset(self::$tags[1]) && self::$tags[1])
            echo self::$tags[1];
    }

    /**
     * Echo variable to a file
     *
     * You can override the file to use by overriding `Debug::$file`.
     *
     * @param one or more variables to dump
     * @retval void | string Returns a string when there are errors, else void
    **/
    public static function file() # variable argument list
    {
        if (!self::$debug)
            return;

        if (!$n_args = func_num_args())
            return 'Debug::file(): Please pass one or more variables';

        $str = '';
        $a_args = func_get_args();
        for ($i = 0; $i < $n_args; $i++) {
            if (!self::override($a_args[$i], 'file')) {
                $str .= self::dump($a_args[$i]);
            }
        }

        $content = "Added at " . date('r') . "\n$str\n\n";
        file_put_contents(self::$file, $content, LOCK_EX | FILE_APPEND);
    }

    /**
    ** Return a string representation of variables
    **
    ** This may be useful to dump a $var to a different stream/variable,
    ** or if you don't want it be echoed out. The main public methods
    ** `text`, `html` and `file` all make use of this method.
    **
    ** @param one or more variables to dump
    ** @retval string Representation of variables
    **/
    public static function dump() # variable argument list
    {
        $dump_single_var = function($var) {
            if (is_array($var) || is_object($var))
                return print_r($var, true);

            ob_start();
            var_dump($var);
            return ob_get_clean();
        };

        if (!$n_args = func_num_args())
            return 'Debug::dump(): Please pass one or more variables';

        $str = '';
        $a_args = func_get_args();
        for ($i = 0; $i < $n_args; $i++)
            $str .= $dump_single_var($a_args[$i]);
        return $str;
    }

    /**
     * Private method for handling overrides of `text`, `html` or `file`
     *
     * @param mixed $var The variable to dump.
     * @param string $type Name of the callee
     * @retval bool Returns true if method is overridden
    **/
    private static function override($var, $type)
    {
        $types = ['text', 'html', 'file'];
        if (!self::$debug || !in_array(self::$debug, $types, true))
            return false;

        if (self::$debug !== $type) {
            self::{self::$debug}($var);
            return true;
        }
        return false;
    }
}
