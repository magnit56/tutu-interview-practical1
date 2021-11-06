<?php

namespace Magnit56\PhpInterview;

class Discount
{
    const RETIRED_DISCOUNT = 0.05;
    const FIRST_PURCHASE_DISCOUNT = 100;
    const BIG_CHECK = 10000;
    const BIG_CHECK_DISCOUNT = 500;

    private function getRetiredDiscount($cart)
    {
        return ($cart->getConsumer()->isRetiredPerson()) ? $cart->getTotalAmount() * self::RETIRED_DISCOUNT : 0;
    }

    private function getFirstPurchaseDiscount($cart)
    {
        return ($cart->getConsumer()->hasPreviousPurchases()) ? 0 : self::FIRST_PURCHASE_DISCOUNT;
    }

    private function getBigCheckDiscount($cart)
    {
        return ($cart->getTotalAmount() >= self::BIG_CHECK) ? self::BIG_CHECK_DISCOUNT : 0;
    }

    public function getTotalDiscount($cart): int
    {
        $retiredDiscount = $this->getRetiredDiscount($cart);
        $firstPurchaseDiscount = $this->getFirstPurchaseDiscount($cart);
        $bigCheckDiscount = $this->getBigCheckDiscount($cart);
        $maxPossibleDiscount = $retiredDiscount + $firstPurchaseDiscount + $bigCheckDiscount;
        return ($cart->getTotalAmount() >= $maxPossibleDiscount) ? $maxPossibleDiscount : $cart->getTotalAmount();
    }
}
