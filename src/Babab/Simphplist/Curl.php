<?php
/*
 * Simphplist Curl
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
 * @class Curl
 * @brief Simplistic cURL handler
 */

class Curl {
    private $_content;
    private $_cookies;
    private $_curl;

    public function __construct($url, $port=null)
    {
        $this->_curl = curl_init($url);
        curl_setopt_array($this->_curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_PORT => $port ?: 80,
            CURLOPT_COOKIEJAR => '-',
            CURLOPT_HEADERFUNCTION => array($this, '_parseHeaders'),
            /* CURLOPT_COOKIEJAR => '/tmp/cookiejar', */
            CURLOPT_USERAGENT => 'Babab::Simphplist::Curl'
        ));
    }

    public function setUrl($url)
    {
        curl_setopt($this->_curl, CURLOPT_URL, $url);
        return $this;
    }

    public function run()
    {
        $this->_content = curl_exec($this->_curl);
        return $this;
    }

    public function get($type='plain')
    {
        if ($type === 'json')
            return json_decode($this->_content);
        else
            return $this->_content;
    }

    public function getCookie($name)
    {
        if (isset($this->_cookies[$name]))
            return $this->_cookies[$name];
    }

    private function _parseHeaders($curl, $header)
    {
        print_r($header);
        preg_match('/^Set-Cookie:\s*([^;]*)/mi', $header, $match);

        if (isset($match[1]))
            parse_str($match[1], $this->_cookies);

        return strlen($header);
    }

    public function __destruct()
    {
        curl_close($this->_curl);
    }
}
