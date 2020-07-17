<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use RetailerWithProductSeeder;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   public function it_tracks_product_stock()
   {
       $this->seed(RetailerWithProductSeeder::class);

        $this->assertFalse(Product::first()->inStock());

       Http::fake(static fn() => ['available' => true, 'price' => 29000]);

       //When
       // I trigger the php artisan track command
       // and assuming the stock available now
       $this->artisan('track')->expectsOutput('Done!');

       //Then
       //The stock details should be refreshed
       $this->assertTrue(Product::first()->inStock());
   }
}
