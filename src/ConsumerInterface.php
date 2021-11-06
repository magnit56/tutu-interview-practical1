<?php

namespace Magnit56\PhpInterview;

interface ConsumerInterface
{
    //для предоставления скидки покупателю хотелось бы, чтобы именно эти методы были реализованы
    public function isRetiredPerson();
    public function hasPreviousPurchases();
}
