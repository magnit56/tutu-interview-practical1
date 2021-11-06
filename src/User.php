<?php

namespace Magnit56\PhpInterview;

const SEXES = ['male', 'female'];
const BOOL_VALUES = [true, false];

class User implements ConsumerInterface
{
	private $sex;
	private $age;
	private $hasPreviousPurchases;

	public function __construct()
	{
		$this->sex = getRandomItemFromArray(SEXES);
		$this->age = mt_rand(15, 80);
		$this->hasPreviousPurchases = getRandomItemFromArray(BOOL_VALUES);
	}

	public function getAge(): int
	{
		return $this->age;
	}

	public function getSex(): string
	{
		return $this->sex;
	}

	public function isRetiredPerson(): bool
	{
		//упрощенная версия, сейчас есть пенсионеры-женщины по старости младше 60 лет
		$age = $this->getAge();
		$sex = $this->getSex();
		return ($sex === 'male') ? $age >= 65 : $age >= 60;
	}

	public function hasPreviousPurchases(): bool
	{
		//такой метод в Laravel будет выглядеть примерно так
		//$purchases = Purchase::all();
		//return $purchases->count() > 0;
		return $this->hasPreviousPurchases;
	}
}

function getRandomItemFromArray($arr)
{
	return $arr[array_rand($arr)];
}
