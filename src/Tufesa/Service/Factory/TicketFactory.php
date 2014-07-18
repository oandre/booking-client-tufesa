<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Ticket;

class TicketFactory
{
    public static function create(array $ticketData)
    {
        self::validateRequiredFields($ticketData);

        $ticket = new Ticket();
        $ticket->setId($ticketData["_id"]);
        $ticket->setSerie($ticketData["_serie"]);
        $ticket->setFrom($ticketData["_from"]);
        $ticket->setTo($ticketData["_vTO"]);

        $departureDateTime = \DateTime::createFromFormat(
            "Ymd H:i",
            $ticketData["_departure_date"] . " " . $ticketData["_departure_time"]
        );

        $ticket->setDepartureDateTime($departureDateTime);
        $ticket->setService($ticketData["_service"]);
        $ticket->setCustomer(CustomerFactory::create([
            "name" => $ticketData["_customer"]["_name"],
            "category" => $ticketData["_customer"]["_category"],
            "seat" => $ticketData["_customer"]["_seat"]
        ]));
        $ticket->setTotal($ticketData["_total"]);
        $ticket->setTax($ticketData["_tax"]);
        $ticket->setTimeStamp($ticketData["_time_stamp"]);

        return $ticket;
    }

    public static function validateRequiredFields(array $ticketData)
    {
        if (!isset($ticketData["_id"])) {
            throw new \InvalidArgumentException("The field id is required");
        }

        if (!isset($ticketData["_serie"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_from"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_vTO"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_departure_date"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_departure_time"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_service"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_customer"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_total"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_tax"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }

        if (!isset($ticketData["_time_stamp"])) {
            throw new \InvalidArgumentException("The field serie is required");
        }
    }
}
