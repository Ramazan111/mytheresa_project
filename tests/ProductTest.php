<?php

namespace App\Tests;

use App\Entity\Price;
use App\Entity\Product;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testShow()
    {
        $client = new Client([
            'base_url' => 'http://localhost:8000'
        ]);
        $request = $client->get("/product");

        $this->assertEquals(201, $request->getStatusCode());
        $this->assertTrue($request->hasHeader('Location'));
    }


}
