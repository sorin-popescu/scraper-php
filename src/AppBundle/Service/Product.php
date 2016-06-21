<?php

namespace AppBundle\Service;


use AppBundle\Entity\Product as ProductEntity;

class Product
{
    private $products;

    public function __construct()
    {
        $this->products = [];
    }

    public function addProduct(ProductEntity $product)
    {
        $this->products[] = [
            'title' => $product->getTitle(),
            'size' => $product->getSize(),
            'unit_price' => $product->getUnitPrice(),
            'description' => $product->getDescription()
        ];
    }

    public function getProducts()
    {
        return ['results' => $this->products];
    }
}