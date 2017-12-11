<?php

namespace Cenoura\Common\Library\Http;

class Client
{
    protected $error;

    protected $handle;

    public function __construct()
    {
        if ( ! $this->isCurlAvailable()) {
            throw new \Exception('cURL extension not loaded.');
        }

        $this->handle = curl_init();
    }

    protected function isCurlAvailable()
    {
        return extension_loaded('curl');
    }

    public function request($method, $url, $vars = [])
    {
        $this->error = '';

        if (is_array($vars)) {
            $vars = http_build_query($vars, '', '&');
        }

        $this->setRequestMethod($method);
        $this->setRequestOptions($url, $vars);

        $response = curl_exec($this->handle);

        if ($response) {
            $response = new Response($response);
        } else {
            throw new \Exception(curl_errno($this->handle) . ' - ' . curl_error($this->handle));
        }

        curl_close($this->handle);

        return $response;
    }

    public function setRequestMethod($method)
    {
        switch (strtoupper($method)) {
            case 'HEAD':
                $option = CURLOPT_NOBODY;
                $value  = true;

                break;

            case 'GET':
                $option = CURLOPT_HTTPGET;
                $value  = true;

                break;

            case 'POST':
                $option = CURLOPT_POST;
                $value  = true;

                break;

            default:
                $option = CURLOPT_CUSTOMREQUEST;
                $value  = $method;
        }

        curl_setopt($this->handle, $option, $value);
    }

    protected function setRequestOptions($url, $vars = [])
    {
        curl_setopt_array(
            $this->handle,
            [
                CURLOPT_URL            => $url,
                CURLOPT_HEADER         => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
            ]
        );
    }

    public function get($url, $vars = [])
    {
        if (!empty($vars)) {
            $url .= (stripos($url, '?') !== false) ? '&' : '?';
            $url .= (is_string($vars)) ? $vars : http_build_query($vars, '', '&');
        }

        return $this->request('GET', $url);
    }

    //TODO: post, head, delete, etc
}
