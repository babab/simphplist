<?php
/*
 * Simphplist Route
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

    public function otherwise()
    {
        if ($this->_matched)
            return $this;
        $this->_matched = true;

        if (!$n_args = func_num_args())
            return $this;

        $a_args = func_get_args();
        $closureArgs = [];

        // add optional arguments to the closure and ultimately call
        // when a callable is found (which can also be a predefined function
        for ($i = 0; $i < $n_args; $i++) {
            // the closure should always be last
            if (is_callable($a_args[$i])) {
                $function = new \ReflectionFunction($a_args[$i]);
                $function->invokeArgs($closureArgs);
                return $this;
            }
            else {
                // add to closure argument list
                $closureArgs[] = $a_args[$i];
            }
        }
    }

    public function when()
    {
        if ($this->_matched)
            return $this;

        // Check for arguments and load them, argument 1
        // should always be a string with path, or an array
        // with path (and an array of) method(s)
        if (!$n_args = func_num_args())
            return $this;

        $a_args = func_get_args();
        $methods = 'all';

        if (is_array($a_args[0])) {
            $methods = [];

            if (!isset($a_args[0][0]) || !isset($a_args[0][1]))
                return $this;

            $path = $a_args[0][0];

            if (!is_string($path))
                return $this;

            if (is_array($a_args[0][1]))
                $methods = array_merge($methods, $a_args[0][1]);
            elseif (is_string($a_args[0][1]))
                $methods[] = $a_args[0][1];
            else
                return $this;
        }
        else {
            if (!is_string($a_args[0]))
                return $this;
            $path = $a_args[0];
        }

        // parse path and save closure arguments in $closureArgs
        if (!$closureArgs = $this->parseURI($path, $methods))
            return $this;

        // if $closureArgs is true it means there are no arguments
        // but there still is a valid match; make sure to pass an
        // array to the closure
        if ($closureArgs === true)
            $closureArgs = [];

        // When this point has been reached, there seems to be a match,
        // any subsequent calls should not have any effect.
        $this->_matched = true;

        // add optional arguments to the closure and ultimately call
        // when a callable is found (which can also be a predefined function
        for ($i = 1; $i < $n_args; $i++) {
            // the closure should always be last
            if (is_callable($a_args[$i])) {
                $function = new \ReflectionFunction($a_args[$i]);
                $function->invokeArgs($closureArgs);
                return $this;
            }
            else {
                // add to closure argument list
                $closureArgs[] = $a_args[$i];
            }
        }
    }

    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
        return $this;
    }

    public function parseURI($referencePath, $methods = 'all')
    {
        $uri = htmlentities($_SERVER['REQUEST_URI']);

        // Check REQUEST_URI for a QUERY_STRING and strip it
        $querystringDelimiter = strpos($uri, '?');
        if ($querystringDelimiter !== false)
            $uri = substr($uri, 0, $querystringDelimiter);

        $valid_method = false;

        if ($methods === 'all') {
            $valid_method = true;
        }
        else {
            if (!is_array($methods))
                return false;

            foreach ($methods as $method) {
                if (strtolower($_SERVER['REQUEST_METHOD'])
                    == strtolower($method)) {
                    $valid_method = true;
                }
            }
        }

        if (!$valid_method)
            return false;

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

            $identifier = strpos($p, ':');

            if ($identifier !== false) {
                // add to closure
                $value = filter_var($uri[$i], FILTER_SANITIZE_STRING);
                $closure_args[substr($p, 1)] = $value;
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
