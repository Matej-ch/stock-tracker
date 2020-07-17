<?php


namespace App\Clients;

use Illuminate\Support\Facades\Http;
use App\Stock;

class Alza implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get('https://www.alza.sk/')->json();

        return new StockStatus(
            $results['available'],
            $results['price']
        );
    }
}
