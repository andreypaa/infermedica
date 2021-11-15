<?php


namespace App\Service;

class Req
{
    public $apiUrl = 'https://api.infermedica.com/v3/';

    public function get(string $url): ?string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl.$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        /* @noinspection CurlSslServerSpoofingInspection */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'App-Id: 1234567',
            'App-Key: 1234567',

        ]);

        $html = curl_exec($ch);
        curl_close($ch);

        return $html ?? null;
    }
}
