<?php

namespace Tufesa\Service\Type;

class Customers extends \ArrayObject
{
    public function append($customer)
    {
        if (!$customer instanceof Customer) {
            throw new \InvalidArgumentException("An instance of Tufesa\\Service\\Type\\Customer is required");
        }

        parent::append($customer);
    }
}
