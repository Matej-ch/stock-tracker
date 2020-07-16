<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function it_tracks_product_stock()
   {
        //Given
       //I have product in stock
       $switch = Product::create(['name' => 'Nintendo Switch']);

       $alza = Retailer::create(['name' => 'Best buy']);

       $this->assertFalse($switch->inStock());

       $stock = new Stock([
           'price' => 10000,
           'url' => 'http://www.alza.sk',
           'sku' => '123456',
           'in_stock' => false,
       ]);

       $alza->addStock($switch,$stock);
       $this->assertFalse($stock->fresh()->in_stock);

       Http::fake(function () {
           return [
               'available' => true,
               'price' => 29000
           ];
       });
       //When
       // I trigger the php artisan track command
       // and assuming the stock available now
       $this->artisan('track');

       //Then
       //The stock details should be refreshed
       $this->assertTrue($stock->fresh()->in_stock);
   }
}
