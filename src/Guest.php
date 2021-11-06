<?php

namespace Magnit56\PhpInterview;

class Guest implements ConsumerInterface
{
	public function isRetiredPerson(): bool
	{
        //гость не может подтвердить никак, что он пенсионер
        return false;
    }

	public function hasPreviousPurchases(): bool
	{
        //у гостя не может быть предыдущих покупок
        return false;
    }
}
