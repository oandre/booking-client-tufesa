<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Customer;

class CustomerFactory
{
    public static function create(array $customerData)
    {
        self::validateRequiredFields($customerData);

        $customer = new Customer();
        $customer->setName($customerData["name"]);
        $customer->setCategory($customerData["category"]);
        $customer->setSeat($customerData["seat"]);

        return $customer;
    }

    public static function validateRequiredFields(array $customerData)
    {
        if (!isset($customerData["name"])) {
            throw new \InvalidArgumentException("The customer name is required");
        }

        if (!isset($customerData["category"])) {
            throw new \InvalidArgumentException("The customer category is required");
        }

        if (!isset($customerData["seat"])) {
            throw new \InvalidArgumentException("The customer seat is required");
        }
    }
}
