<?php

namespace App\Controller;

use App\Entity\Price;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    private array $discountCategory = ["boots", 30];
    private array $discountSku = ["000003", 15];
    private string $currencyCode = "EUR";
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function index(Request $request, SerializerInterface $serializer)
    {
        $categoryFilter = $request->query->get('category');
        $priceFilter = $request->query->get('priceLessThan');

        $this->doctrine->getRepository(Price::class)->findAll();
        if ($categoryFilter != null) {
            $product = $this->doctrine->getRepository(Product::class)->findByCategory($categoryFilter);
        } else if ($priceFilter != null) {
            $product = $this->doctrine->getRepository(Product::class)->findByPrice($priceFilter);
        } else {
            $product = $this->doctrine->getRepository(Product::class)->findAll();
        }

        return new Response($serializer->serialize($product,'json'));
    }

    public function createProduct(): Response
    {
        $jsonData = json_decode(file_get_contents('public/data.json'));

        $entityManager = $this->doctrine->getManager();

        foreach ($jsonData->products as $prod) {
            $product = new Product();
            $product->setSku($prod->sku);
            $product->setName($prod->name);
            $product->setCategory($prod->category);
            $price = new Price();
            $price->setOriginal($prod->price);
            $price->setFinal($prod->price);
            if ($prod->sku == $this->discountSku[0]) {
                $price->setFinal((int) round($prod->price * ((100 - $this->discountSku[1])/100)));
                $price->setDiscountPercentage($this->discountSku[1] . "%");
            }
            if ($prod->category == $this->discountCategory[0]) {
                $price->setFinal((int) round($prod->price * ((100 - $this->discountCategory[1])/100)));
                $price->setDiscountPercentage($this->discountCategory[1] . "%");
            }
            $price->setCurrency($this->currencyCode);
            $entityManager->persist($price);
            $product->setPrice($price);
            $entityManager->persist($product);
        }

        $entityManager->flush();

        return new Response('All products are saved!');
    }
}
