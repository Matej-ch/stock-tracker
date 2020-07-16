<?php

namespace App;

use Illuminate\Support\Facades\Http;

class Stock extends Model
{
    protected $table = 'stock';

    protected $casts = [
        'in_stock' => 'boolean'
    ];

    public function track()
    {
        //@todo load data from api
        $result = Http::get('https://www.alza.sk/')->json();

        $this->update([
            'in_stock' => $result['available'],
            'price' => $result['price'],
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
