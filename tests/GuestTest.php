<?php

namespace Magnit56\PhpInterview;


use PHPUnit\Framework\TestCase;
use Magnit56\PhpInterview\Guest;

class GuestTest extends TestCase
{
    public $guest;

    public function setUp(): void
    {
        $this->guest = new Guest();
    }

    public function testIsRetiredPerson(): void
    {
        $this->assertFalse($this->guest->isRetiredPerson());
    }

    public function testHasPreviousPurchases(): void
    {
        $this->assertFalse($this->guest->hasPreviousPurchases());
    }
}
