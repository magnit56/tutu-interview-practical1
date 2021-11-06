<?php

namespace Magnit56\PhpInterview;

const PRICES_FROM_ID = [
    '1' => 1000,
    '2' => 1100,
    '3' => 900,
    '4' => 1400,
    '5' => 1600,
    '6' => 1000,
    '7' => 1100,
    '8' => 700,
    '9' => 900    
];
const DEFAULT_PRICE = 9620;

class Product
{
    private $id;
    private $price;
    private $sku;

    public function __construct($id)
    {
        $this->id = $id;
        $this->price = PRICES_FROM_ID[$id] ?? DEFAULT_PRICE;//типо прайс назначается из массива (в реале из БД)
        $this->sku = "sku{$this->id}";//типо sku должен быть взаимно-однозначным с id (в реале из БД возьмем)
    }

	public function getId(): int
	{
        return $this->id;
    }

	public function getPrice(): int
	{
        return $this->price;
    }

	public function getSku(): string
	{
        return $this->sku;
    }

    //сеттеров нет, типо пока непонятно нужны ли они вообще в задании
}
