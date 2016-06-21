<?php

namespace AppBundle\Entity;


class Product
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $size;

    /**
     * @var string
     */
    private $unitPrice;

    /**
     * @var string
     */
    private $description;

    /**
     * Product constructor.
     * @param $title
     * @param $size
     * @param $unitPrice
     * @param $description
     */
    public function __construct($title, $size, $unitPrice, $description)
    {
        $this->title = $title;
        $this->size = $size;
        $this->unitPrice = $unitPrice;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
