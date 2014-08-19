<?php
/*
 * Simphplist Debug
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

namespace Babab\Simphplist;

/**
 * @class Debug
 * @brief Static methods for dumping vars to a file or screen (html or text)
 *
 * "The most effective debugging tool is still careful thought, coupled
 * with judiciously placed print statements." -- Brian Kernighan
 *
 * The Simphplist debug class is just some fancy wrappers around
 * var_dump and print_r, but provides a straight-forward way of dumping
 * values to either the screen or a file.
 *
 * @warning You need to set the Debug::$debug for it to work! Simphplist
 * Debug adds protection (in production environments) and flexibility by
 * using a trigger setting (Debug::$debug) that needs to be explicitly
 * set to true-ish before it will output anything. Leaving or setting
 * it at a value that evaluates as false will make sure leftover debug
 * calls will not do anything. You can set the $debug value to 'text',
 * 'html' or 'file' to override the dump method used, no mather what
 * method is actually called in the code.
 */
class Debug
{
    /**
     * Debug value, can be a boolean or a string with the method used
     * for overriding debug method calls.
     */
    public static $debug = false;

    /**
     * String with the complete path to the dumpfile used in Debug::file
     * method calls.
     */
    public static $file = '/tmp/simphplist-debug.log';

    /**
     * Echo variable as a simple text string
     *
     * @param mixed $var The variable to dump.
     * @retval bool Returns true if the dump was actually done, else false.
    **/
    public static function text($var)
    {
        if (!self::$debug)
            return false;
        if (self::override($var, 'text'))
            return true;

        echo self::dump($var);
        return true;
    }

    /**
     * Echo variable html formatted text string (<pre> block by default)
     *
     * @param mixed $var The variable to dump.
     * @param array $tags A 2-item array with the start and end html tags.
     * @retval bool Returns true if the dump was actually done, else false.
    **/
    public static function html($var, $tags = ['<pre>', '</pre>'])
    {
        if (!self::$debug)
            return false;
        if (self::override($var, 'html'))
            return true;

        echo $tags[0];
        echo self::dump($var);

        if (isset($tags[1]) && $tags[1])
            echo $tags[1];
        return true;
    }

    /**
     * Echo variable to a file
     *
     * You can override the file to use by overriding `Debug::$file`.
     *
     * @param mixed $var The variable to dump.
     * @param bool $resetFile Set to true to clear the file initially.
     * @retval bool Returns true if the dump was actually done, else false.
    **/
    public static function file($var, $resetFile = false)
    {
        if (!self::$debug)
            return false;
        if (self::override($var, 'file'))
            return true;

        $content = "Added at " . date('r') . "\n" . self::dump($var) . "\n\n";

        if ($resetFile)
            file_put_contents(self::$file, $content, LOCK_EX);
        else
            file_put_contents(self::$file, $content, LOCK_EX | FILE_APPEND);
        return true;
    }

    /**
     * Return a string representation of $var
     *
     * This may be useful to dump a $var to a different stream/variable,
     * or if you don't want it be echoed out. The main public methods
     * `text`, `html` and `file` all make use of this method.
     *
     * @param mixed $var The variable to dump.
     * @retval string Representation of $var
    **/
    public static function dump($var)
    {
        if (is_array($var) || is_object($var))
            return print_r($var, true);

        ob_start();
        var_dump($var);
        return ob_get_clean();
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

        if (self::$debug !== $type)
            return self::{self::$debug}($var);
        return false;
    }
}
