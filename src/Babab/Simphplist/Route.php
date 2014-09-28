<?php
/*
 * Simphplist Route
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
 * @class Route
 * @brief Minimalistic, flexible and extensible routing
 */

class Route {

    public static function redirect($uri, $httpPrefixer = false)
    {
        if ($httpPrefixer && strpos($uri, 'http') === false)
            $uri = 'http://' . $uri;
        header("Location: $uri");
        exit;
    }

    private $_prefix;

    // Set to true when a when match is found to stop routing
    private $_matched = false;

    /**
     * Run a default closure when no other previous `when()` calls
     * have matched. The closure cannot accept arguments.
     *
     * @param callable $func A closure or variable function to run
     * @retval bool | array Match success or matched identifier pair
     */
    public function otherwise($func)
    {
        if ($this->_matched)
            return $this;

        $func();
        $this->_matched = true;
        return $this;
    }

    /**
     * Run a closure when the visited URL matches the defined URI format
     *
     * An $uri can have identifiers, which are marked with `{}`.
     * In the following example there is an 'id' identifier
     * for a blog article:
     *
     *     $foo = 'bar';
     *
     *     (new \Babab\Simphplist\Routing\Route)
     *
     *     ->when('/articles/{id}/, function($id) {
     *          echo 'This is article: ' . $id;
     *     })
     *
     *     ->when('/articles/, function() {
     *          echo 'This is the article list';
     *     })
     *
     *     ->when('/archive/{y}/{m}/, $foo, function($y, $m, foo) {
     *          echo 'This is article: ' . $id;
     *     })
     *
     *     ->when('/archive/, $foo, function(foo) {
     *          echo 'This is article: ' . $id;
     *     })
     *
     *     ->otherwise(function() {
     *         \Babab\Simphplist\Route::redirect('/articles/');
     *     });
     *
     * When the url is matched, any values that are matched with
     * identifiers are made available as arguments of the closure, in
     * left-to-right order. Any extra arguments passed between the
     * URI string and the closure function are also made available as
     * arguments of the closure, after the identifier arguments.
     *
     * @param string $uri The URI format to match for
     * @param ... optional arguments to pass to closure
     * @param callable $func A closure or variable function to run
     * @retval bool | array Match success or matched identifier pair
     */
    public function when()
    {
        if ($this->_matched)
            return $this;

        // Check for arguments and load them, argument 1
        // should always be the path
        if (!$n_args = func_num_args())
            return $this;

        $a_args = func_get_args();
        $path = $a_args[0];

        if (!is_string($path))
            return $this;

        // parse path and save closure arguments in $match
        if (!$match = $this->parseURI($path))
            return $this;

        // if $match is true it means there are no arguments but there
        // still is a valid match; make sure to pass an array to the
        // closure
        if ($match === true)
            $match = [];

        // When this point has been reached, there seems to be a match,
        // any subsequent calls should not have any effect.
        $this->_matched = true;

        // add optional arguments to the closure and ultimately call
        // when a callable is found (which can also be a predefined function
        for ($i = 1; $i < $n_args; $i++) {
            // the closure should always be last
            if (is_callable($a_args[$i])) {
                $function = new \ReflectionFunction($a_args[$i]);
                $function->invokeArgs($match);
                return $this;
            }
            else {
                // add to closure argument list
                $match[] = $a_args[$i];
            }
        }
    }

    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
        return $this;
    }

    /**
     * Match REQUEST_URI with $reference path
     *
     * The REQUEST_URI is optionally stripped with prefix before
     * matching (useful for developing without rewriting rules, with
     * PHP's built in webserver for example)
     *
     * Returns an asscoitative array with matched identifier pairs when
     * applicable;
     * Returns true then a match is found without identifiers;
     * Returns false when no match is found
     *
     * @param string $referencePath The URI format to match for
     * @retval bool | array Match success or matched identifier pair
     */
    public function parseURI($referencePath)
    {
        $uri = htmlentities($_SERVER['REQUEST_URI']);

        if ($pln = strlen($this->_prefix))
            $uri = substr($uri, $pln);

        $uri = explode('/', $uri);
        $referencePathComponents = explode('/', $referencePath);

        // stop if the number of /'s do not match
        if (count($uri) != count($referencePathComponents))
            return false;

        // parse referencePath and add identifier matches to closure_args
        $i = 0;
        $closure_args = [];
        foreach ($referencePathComponents as $p) {
            if (!isset($uri[$i]))
                return false;

            $d1 = strpos($p, '{');
            $d2 = strpos($p, '}');

            if ($d1 !== false && $d2 !== false) {
                // add to closure
                $value = filter_var($uri[$i], FILTER_SANITIZE_STRING);
                $closure_args[substr($p, 1, $d2 - 1)] = $value;
            }
            else {
                // continue on string match, else end it here
                if ($p !== $uri[$i])
                    return false;
            }
            $i++;
        }
        return $closure_args ?: true;
    }
}
