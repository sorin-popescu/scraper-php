<?php

namespace Test\AppBundle\Service;


use AppBundle\Service\Product as ProductService;
use AppBundle\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testAddProduct()
    {
        $productService = new ProductService();
        $product = $this->getMockBuilder(Product::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $productService->addProduct($product);

        $products = $productService->getProducts();

        $this->assertCount(1, $products);
    }
}