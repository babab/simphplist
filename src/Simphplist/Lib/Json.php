<?php
/*
 * Simphplist Json
 *
 * Copyright (c) 2014-2016 Benjamin Althues <benjamin@babab.nl>
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

namespace Simphplist\Lib;

class Json {
    #@ Shortcuts for common idioms in JSON interaction

    /* input methods */

    public static function input()
    {
        return json_decode(file_get_contents('php://input'));
    }

    /* output methods */

    public static function stringify($obj)
    {
        return print_r(json_encode($obj), true);
    }

    public static function msgerr($message, $error)
    {
        return self::stringify([
            'message' => $message, 'error' => $error
        ]);
    }

    public static function message($message)
    {
        return self::msgerr($message, '');
    }

    public static function error($error)
    {
        return self::msgerr('', $error);
    }
}
