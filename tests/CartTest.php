<?php

namespace Magnit56\PhpInterview;

use PHPUnit\Framework\TestCase;
use Magnit56\PhpInterview\Cart;
use Magnit56\PhpInterview\User;
use Magnit56\PhpInterview\Product;

class CartTest extends TestCase
{
    public $cart;
    public $user;
    public $firstProduct;
    public $secondProduct;
    public $thirdProduct;

    public function setUp(): void
    {
        $this->user = new User();
        $this->cart = new Cart($this->user);
        $this->firstProduct = new Product(1);
        $this->secondProduct = new Product(2);
        $this->thirdProduct = new Product(1);
    }

    public function testAddItem(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);
        $this->assertEquals([
            1 => [
                'item_id' => 1,
                'count' => 2
            ],
            2 => [
                'item_id' => 2,
                'count' => 1
            ]
        ], $this->cart->getItems());
    }

    public function testMinusItem(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);
        $this->cart->minusItem(1);
        $this->assertEquals([
            1 => [
                'item_id' => 1,
                'count' => 1
            ],
            2 => [
                'item_id' => 2,
                'count' => 1
            ]
        ], $this->cart->getItems());
        $this->cart->minusItem(1);
        $this->assertEquals([
            2 => [
                'item_id' => 2,
                'count' => 1
            ]
        ], $this->cart->getItems());
    }

    public function testDestroyItem(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);
        $this->cart->destroyItem(1);
        $this->assertEquals([
            2 => [
                'item_id' => 2,
                'count' => 1
            ]
        ], $this->cart->getItems());
    }

    public function testFlush(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);
        $this->cart->flush();
        $this->assertEquals([], $this->cart->getItems());
    }

    public function testSetItemCount(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);
        $this->cart->setItemCount($this->firstProduct->getId(), 10);
        $this->assertEquals([
            1 => [
                'item_id' => 1,
                'count' => 10
            ],
            2 => [
                'item_id' => 2,
                'count' => 1
            ]
        ], $this->cart->getItems());
        $this->expectException(\Exception::class);
        $this->cart->setItemCount($this->secondProduct->getId(), 0);
    }

    public function testGetTotalAmount(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);

        $actual = $this->cart->getTotalAmount();
        $expected = $this->firstProduct->getPrice() + $this->secondProduct->getPrice() + $this->thirdProduct->getPrice();
        $this->assertEquals($expected ,$actual);
    }

    public function testGetDiscountedTotalAmount(): void
	{
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);

        $actual = $this->cart->getDiscountedTotalAmount();
        $this->assertTrue(in_array($actual, [2845, 2945, 3000, 3100]));
	}

	public function testGetDiscount(): void
	{
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);

        $actual = $this->cart->getDiscount();
        $this->assertTrue(in_array($actual, [0, 100, 155, 255]));
	}

    public function testGetCartData()
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);

        $data = $this->cart->getCartData();
        $this->assertEquals(2, $data['items'][1]['count']);
        $this->assertEquals(3100, $data['totalAmount']);

        $arr = [
			'items' => [
                1 => [
                    'id' => 1,
                    'count' => 2,
                    'price' => 1000,
                    'discount' => 82,
                    'discountedPrice' => 918,
                    'amount' => 2000,
                    'discountAmount' => 164,
                    'discountedAmount' => 1836,
                ],
                2 => [
                    'id' => 2,
                    'count' => 1,
                    'price' => 1100,
                    'discount' => 90,
                    'discountedPrice' => 1010,
                    'amount' => 1100,
                    'discountAmount' => 180,
                    'discountedAmount' => 2020,
                ]
            ],
			'totalAmount' => 3100,
			'discount' => 255,
			'totalDiscountedAmount' => 2845,
		];
    }
}
