<?php

namespace Tests\Unit;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_stock_for_products_at_retailers()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $alza = Retailer::create(['name' => 'Alza']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 10000,
            'url' => 'http://www.alza.sk',
            'sku' => '123456',
            'in_stock' => true,
        ]);

        $alza->addStock($switch,$stock);

        $this->assertTrue($switch->inStock());
    }
}
