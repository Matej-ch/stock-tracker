<?php


namespace App\Clients;

use Illuminate\Support\Facades\Http;
use App\Stock;

class Aukro implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results =  Http::get('https://www.aukro.pl/')->json();

        return new StockStatus(
            $results['available'],
            $results['price']
        );
    }
}
