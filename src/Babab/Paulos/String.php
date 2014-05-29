<?php
/*
 * Paulos Text
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

class String
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

    public static function filter($var, $castToType='string', $defaultValue='')
    {
        $filtered = filter_var($var, FILTER_SANITIZE_STRING);
        $ret = $filtered ?: $defaultValue;
        switch ($castToType) {
        case 'string':
            return $ret;
        case 'int':
        case 'i':
            return (int) $ret;
        case 'float':
        case 'double':
        case 'f':
        case 'd':
            return (float) $ret;
        case 'commafloat':
        case 'cf':
            return (float) str_replace(',', '.', $ret);
        default:
            throw new \Exception('Unknown/unsupported casting type');
        }
    }

    public static function count($text)
    {
        if (trim($text) === '')
            return Null;

        /* Count words */
        $nWords = str_word_count($text);

        /* Count (blank) lines and paragraphs */
        $lines = explode("\n", $text);
        $nLines = count($lines);
        $blankLines = 0;
        $paragraphs = 0;
        $lastLineHasContent = False;

        foreach ($lines as $line) {
            if (trim($line) == '') {
                $blankLines++;
                if ($lastLineHasContent)
                    $paragraphs++;
                $lastLineHasContent = False;
            }
            else
                $lastLineHasContent = True;
        }

        if (trim($lines[count($lines) - 1]) != '')
            $paragraphs++;

        /* Count chars */
        $chars = array();
        $nChars = 0;
        foreach (str_split($text) as $char) {
            if (!ctype_cntrl($char)) {
                if (!isset($chars[$char]))
                    $chars[$char] = 0;
                $chars[$char]++;
                $nChars++;
            }
        }

        arsort($chars);

        return array(
            'paragraphs' => $paragraphs,
            'lines' => $nLines,
            'lines_blank' => $blankLines,
            'lines_content' => $nLines - $blankLines,
            'words' => $nWords,
            'chars' => $nChars,
            'chars_list' => $chars,
        );
    }
}
