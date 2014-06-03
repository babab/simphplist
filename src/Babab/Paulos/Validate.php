<?php
/*
 * Paulos Validate
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

namespace Babab\Paulos;

class Validate
{
    /**
     * Checks if variable is a true boolean
     *
     * This is an alias for PHP's `is_bool` function adapted with a
     * non strict test to allow case-insensitive strings of "True" and
     * "False"
     *
     * @param mixed $var The variable to test
     * @param bool $strict The variable to test
     * @return bool
     */
    public static function isBool($var, $strict = true)
    {
        if ($strict)
            return is_bool($var);
        else {
            $string = strtolower(trim($var));
            return $var == 'false' || $var == 'true' ? true : false;
        }
    }

    /**
     * Checks if variable is a valid time string
     *
     * Valid strings are: "18:34", "09:00 am", "8:34 PM".
     * Invalid strings are: "18:63", "09:00 aM", "20:34 PM".
     *
     * @param mixed $var The variable to test
     * @return bool
     */
    public static function isTimeString($var)
    {
        return (is_object(DateTime::createFromFormat('h:i a', $var))
                || is_object(DateTime::createFromFormat('h:i', $var)));
    }
}
