<?php

namespace Magnit56\PhpInterview;

use PHPUnit\Framework\TestCase;
use Magnit56\PhpInterview\Cart;
use Magnit56\PhpInterview\User;
use Magnit56\PhpInterview\Product;

use function PHPUnit\Framework\assertEquals;

class DiscountTest extends TestCase
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
        $this->thirdProduct = new Product(10);
    }

    public function testDiscount(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->firstProduct);

        $discount = new Discount();
        $totalDiscount = $discount->getTotalDiscount($this->cart);
        $possibleValues = [0, 100, 155, 255]; //эти все числа взялись из-за того, что в классе User методы isRetiredPerson и hasPreviousPurchases возвращают рандомные значения
        $this->assertTrue(in_array($totalDiscount, $possibleValues));
        //тест ужасный, но пишу его для себя))
    }

    public function testBigCheck(): void
    {
        $this->cart->addItem($this->firstProduct);
        $this->cart->addItem($this->secondProduct);
        $this->cart->addItem($this->thirdProduct);
        assertEquals(9620, $this->thirdProduct->getPrice());

        $discount = new Discount();
        $totalDiscount = $discount->getTotalDiscount($this->cart);
        $possibleValues = [500, 600, 1086, 1186]; //эти все числа взялись из-за того, что в классе User методы isRetiredPerson и hasPreviousPurchases возвращают рандомные значения
        $this->assertTrue(in_array($totalDiscount, $possibleValues));
        //тест ужасный, но пишу его для себя))
    }

}
