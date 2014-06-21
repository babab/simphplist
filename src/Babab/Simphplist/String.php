<?php
/*
 * Simphplist String
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
 * @class String
 * @brief Static methods for common string manipulation / parsing tasks
 */
class String
{
    const WORD_LOWERCASE    = 1;
    const WORD_CAPITALIZED  = 2;
    const WORD_CAMELCASE    = 3;
    const WORD_MIXEDCASE    = 4;
    const WORD_UPPERCASE    = 5;

    /**
     * Truncate a string if it exceeds a certain length
     *
     * The string length of $suffix is taken into account for the
     * maximum number of chars $nChars this method will return.
     *
     * @param string $string The string that is subject to truncation
     * @param int $nChars The maximum number of chars to return
     * @param string $suffix A suffix string to indicate the truncation
     * @retval string A truncated version of $string
     */
    public static function truncate($string, $nChars, $suffix = '...')
    {
        if (strlen($string) <= $nChars)
            return $string;
        else
            return substr($string, 0, ($nChars - strlen($suffix))) . $suffix;
    }

    public static function filter($var, $defaultValue='')
    {
        $filtered = filter_var($var, FILTER_SANITIZE_STRING);
        return $filtered ?: $defaultValue;
    }

    public static function replace($string, $replaceArray)
    {
        $search = array();
        $replace = array();
        foreach ($replaceArray as $repl) {
            $search[] = $repl[0];
            $replace[] = $repl[1];
        }
        return str_replace($search, $replace, $string);
    }


    public static function wordType($word)
    {
        if (self::count($string)['words'] != 1)
            return False;

        if (ctype_lower($word))
            return self::WORD_LOWERCASE;
        elseif (ctype_upper($word))
            return self::WORD_UPPERCASE;
        elseif (ctype_upper(substr($word, 0, 1))
                && ctype_lower(substr($word, 1)))
            return self::WORD_CAPITALIZED;

        $lower = 0;
        $upper = 0;
        foreach (str_split($word) as $char) {
            if (!ctype_cntrl($char)) {
                if (ctype_lower($chars[$char]))
                    $lower++;
                else
                    $upper++;
            }
        }
    }

    public static function count($text)
    {
        if (trim($text) === '')
            return Null;

        /* Count words */
        $nWords = str_word_count($text, 0);
        $words_list = str_word_count($text, 1);

        foreach ($words_list as $word) {
            $word = strtolower($word);
            if (ctype_alnum($word)) {
                if (!isset($words[$word]))
                    $words[$word] = 0;
                $words[$word]++;
            }
        }

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

        /* Reverse sort lists */
        arsort($words);
        arsort($chars);

        /* Calculate percentages for words in $words */
        $wordsWithPercentages = array();
        foreach ($words as $word => $count) {
            $perc = ($count / $nWords) * 100;
            $wordsWithPercentages[$word] = array($count, $perc);
        }

        /* Calculate percentages for chars in $chars */
        $charsWithPercentages = array();
        foreach ($chars as $char => $count) {
            $perc = ($count / $nChars) * 100;
            $charsWithPercentages[$char] = array($count, $perc);
        }

        return array(
            'paragraphs' => $paragraphs,
            'lines' => $nLines,
            'lines_blank' => $blankLines,
            'lines_content' => $nLines - $blankLines,
            'words' => $nWords,
            'words_list' => $wordsWithPercentages,
            'words_unique' => count($words),
            'chars' => $nChars,
            'chars_list' => $charsWithPercentages,
            'chars_unique' => count($chars),
        );
    }

    public static function cast($string, $castToType)
    {
        switch ($castToType) {
        case 'string':
            return (string) $string;
        case 'int':
        case 'i':
            return (int) $string;
        case 'float':
        case 'double':
        case 'f':
        case 'd':
            return (float) $string;
        case 'commafloat':
        case 'cf':
            return (float) str_replace(',', '.', $string);
        default:
            throw new \Exception('Unknown/unsupported casting type');
        }
    }
}
