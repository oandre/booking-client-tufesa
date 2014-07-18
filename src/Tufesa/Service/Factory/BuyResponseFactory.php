<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\BuyRequest;
use Tufesa\Service\Type\BuyResponse;
use Tufesa\Service\Type\Customer;
use Tufesa\Service\Type\Customers;

class BuyResponseFactory
{
    public static function create(array $ticketsData)
    {
        $buyResponse = new BuyResponse();

        foreach ($ticketsData as $ticketData) {
            $buyResponse->append(TicketFactory::create($ticketData));
        }

        return $buyResponse;
    }
}
