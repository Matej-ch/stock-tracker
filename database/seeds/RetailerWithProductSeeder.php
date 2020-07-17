<?php

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Database\Seeder;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Given
        //I have product in stock
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $alza = Retailer::create(['name' => 'Best buy']);

        $stock = new Stock([
            'price' => 10000,
            'url' => 'http://www.alza.sk',
            'sku' => '123456',
            'in_stock' => false,
        ]);

        $alza->addStock($switch,$stock);
    }
}
