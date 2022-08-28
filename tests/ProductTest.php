<?php

namespace App\Tests;

use App\Controller\ProductsController;
use App\Entity\Price;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ProductTest extends TestCase
{

    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testShow()
    {
        $data = json_decode(json_encode([
            "products" => [
                json_decode(json_encode([
                    "sku" => "000001",
                    "name" => "BV Lean leather ankle boots",
                    "category" => "boots",
                    "price" => 89000
                ]))
            ]]));

        $result = (new ProductsController())->setData($data);
        $check = [(new Product())
            ->setSku("000001")
            ->setName("BV Lean leather ankle boots")
            ->setCategory("boots")
            ->setPrice((new Price())
                            ->setOriginal(89000)
                            ->setFinal(62300)
                            ->setDiscountPercentage("30%")
                            ->setCurrency("EUR"))];
        $this->assertEquals($check, $result);
    }


}
