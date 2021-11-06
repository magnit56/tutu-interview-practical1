<?php

namespace Magnit56\PhpInterview;


use PHPUnit\Framework\TestCase;
use Magnit56\PhpInterview\Product;

class ProductTest extends TestCase
{
    public $product;

    public function setUp(): void
    {
        $this->product = new Product(4);
    }

    public function testGetId(): void
    {
        $this->assertEquals(4, $this->product->getId());
    }

    public function testGetPrice(): void
    {
        $this->assertEquals(1400, $this->product->getPrice());
    }

    public function testGetSku(): void
    {
        $this->assertEquals('sku4', $this->product->getSku());
    }
}
