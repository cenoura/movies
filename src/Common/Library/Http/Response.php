<?php

namespace Cenoura\Common\Library\Http;

class Response
{
    protected $headers;

    protected $body;

    public function __construct($response)
    {
        $pattern = '#HTTP/\d\.\d.*?$.*?\r\n\r\n#ims';

        preg_match_all($pattern, $response, $matches);
        $headers = array_pop($matches[0]);
        $arrayHeaders = explode("\r\n", str_replace("\r\n\r\n", '', $headers));

        $this->body = str_replace($headers, '', $response);

        $versionAndStatus = array_shift($arrayHeaders);
        preg_match('#HTTP/(\d\.\d)\s(\d\d\d)\s(.*)#', $versionAndStatus, $matches);
        $this->headers['HTTP-Version'] = $matches[1];
        $this->headers['Status-Code'] = $matches[2];
        $this->headers['Status'] = $matches[2].' '.$matches[3];

        foreach ($arrayHeaders as $header) {
            preg_match('#(.*?)\:\s(.*)#', $header, $matches);
            $this->headers[$matches[1]] = $matches[2];
        }
    }

    public function isSuccessful()
    {
        return $this->headers['Status-Code'] == '200';
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}