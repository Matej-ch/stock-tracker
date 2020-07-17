<?php


namespace App\Clients;


use App\Stock;
use Illuminate\Support\Facades\Http;

class Ebay implements Client
{

    public function checkAvailability(Stock $stock): StockStatus
    {
        $results =  Http::get('http://www.ebay.pl/')->json();

        return new StockStatus(
            $results['available'],
            $results['price']
        );
    }
}
