<?php

namespace AppBundle\Service;


use GuzzleHttp\Client;

class ClientHttp extends Client
{
    public function getContent($url, $size = true)
    {
        $request = $this->request('GET', $url);
        $requestBody = $request->getBody()->getContents();

        if ($size) {
            $requestSize = $request->getBody()->getSize();
            return [
                'body' => $requestBody,
                'size' => $requestSize
            ];
        }

        return [
            'body' => $requestBody
        ];
    }
}