<?php
/*
 * Simphplist Request
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

/**
 * @class Request
 * @brief Static methods for secure user input handling via REQUEST superglobal(s):
 *        (GET, POST, COOKIE)
 */
class Request
{
    public static function get($var, $defaultValue='')
    {
        $filtered = filter_input(INPUT_GET, $var, FILTER_SANITIZE_STRING);
        return $filtered ?: $defaultValue;
    }

    public static function post($var, $defaultValue='')
    {
        $filtered = filter_input(INPUT_POST, $var, FILTER_SANITIZE_STRING);
        return $filtered ?: $defaultValue;
    }
}
