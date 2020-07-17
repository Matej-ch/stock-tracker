<?php

namespace Tests\Unit;


use App\Clients\Client;
use App\Clients\ClientException;
use App\Clients\StockStatus;
use App\Retailer;
use App\Stock;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RetailerWithProductSeeder;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_exception_if_a_client_is_not_found_when_tracking()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Retailer::first()->update(['name' => 'CZC']);

        $this->expectException(ClientException::class);

        Stock::first()->track();

    }

    /** @test  */
    function it_updates_local_stock_status_after_being_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $clientMock = \Mockery::mock(Client::class);
        $clientMock->shouldReceive('checkAvailability')->andReturn(new StockStatus($available = true,$price = 9900));

        ClientFactory::shouldReceive('make')->andReturn($clientMock);

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->in_stock);
        $this->assertEquals(9900,$stock->price);
    }
}
