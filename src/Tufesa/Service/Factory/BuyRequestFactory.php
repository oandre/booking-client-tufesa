<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\BuyRequest;
use Tufesa\Service\Type\Customer;
use Tufesa\Service\Type\Customers;

class BuyRequestFactory
{
    public static function create(array $requestData)
    {
        self::validateRequiredFields($requestData);

        $buyRequest = new BuyRequest();
        $buyRequest->setFrom($requestData["from"]);
        $buyRequest->setTo($requestData["to"]);
        $buyRequest->setDate(\DateTime::createFromFormat("Ymd", $requestData["date"]));
        $buyRequest->setSchedule($requestData["schedule"]);
        $buyRequest->setFolio($requestData["folio"]);
        $buyRequest->setCustomers(self::createCustomers($requestData["customers"]));

        return $buyRequest;
    }

    public static function createCustomers(array $customersData)
    {
        $customers = new Customers();

        foreach ($customersData as $customerData) {
            $customers->append(CustomerFactory::create($customerData));
        }

        return $customers;
    }

    public static function validateRequiredFields(array $requestData)
    {
        if (!isset($requestData["from"])) {
            throw new \InvalidArgumentException("The field from is required");
        }

        if (!isset($requestData["to"])) {
            throw new \InvalidArgumentException("The field to is required");
        }

        if (!isset($requestData["date"])) {
            throw new \InvalidArgumentException("The field date is required");
        }

        if (!isset($requestData["schedule"])) {
            throw new \InvalidArgumentException("The field schedule is required");
        }

        if (!isset($requestData["folio"])) {
            throw new \InvalidArgumentException("The field folio is required");
        }

        if (!isset($requestData["customers"])) {
            throw new \InvalidArgumentException("The field customers is required");
        }

        if (!is_array($requestData["customers"])) {
            throw new \InvalidArgumentException("The field customers must be an array");
        }
    }
}
