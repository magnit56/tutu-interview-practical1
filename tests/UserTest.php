<?php

namespace Magnit56\PhpInterview;


use PHPUnit\Framework\TestCase;
use Magnit56\PhpInterview\User;

class UserTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testGetAge(): void
    {
        $this->assertIsInt($this->user->getAge());
    }

    public function testGetSex(): void
    {
        $this->assertIsString($this->user->getSex());
    }

    public function testIsRetiredPerson(): void
    {
        $this->assertIsBool($this->user->isRetiredPerson());
    }

    public function testHasPreviousPurchases(): void
    {
        $this->assertIsBool($this->user->hasPreviousPurchases());
    }
}
