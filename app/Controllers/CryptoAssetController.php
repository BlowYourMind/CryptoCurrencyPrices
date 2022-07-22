<?php

namespace App\Controllers;

use App\Models\CryptoAsset;
use App\View;

class CryptoAssetController
{
    public function index():View
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD',
        ];
        $apiKey = '7cbb0339-42dc-4d6e-a625-8659afbd47a4';
        $qs = http_build_query($parameters);
        $report = file_get_contents("{$url}{$apiKey}&{$qs}");
        $report = json_decode($report);
        $cryptoReport = [];
        foreach ($report->data as $name) {
            $cryptoReport[] = new CryptoAsset(
                $name->name,
                $name->symbol,
                $name->quote->USD->price
            );
        }
        return new View('crypto-assets-index.twig', ['assets'=>$cryptoReport]);
    }
}