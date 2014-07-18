<?php

namespace Tufesa\Service\Factory;

class TicketFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_id_should_raise_an_exception()
    {
        $ticket = [];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_serie_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_from_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_to_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_departure_date_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_departure_time_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_service_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
            "_departure_time" => "09:00"
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_customer_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
            "_departure_time" => "09:00",
            "_service" => "PLUS",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_total_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
            "_departure_time" => "09:00",
            "_service" => "PLUS",
            "_customer" => []
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_tax_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
            "_departure_time" => "09:00",
            "_service" => "PLUS",
            "_customer" => [],
            "_total" => "1214.00",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_ticket_without_the_field_time_stamp_should_raise_an_exception()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
            "_departure_time" => "09:00",
            "_service" => "PLUS",
            "_customer" => [],
            "_total" => "1214.00",
            "_tax" => "S",
        ];

        TicketFactory::validateRequiredFields($ticket);
    }

    public function test_create_ticket_with_valid_data_should_work()
    {
        $ticket = [
            "_id" => 20540673,
            "_serie" => "OXX",
            "_from" => "GDL",
            "_vTO" => "OBR",
            "_departure_date" => "20140720",
            "_departure_time" => "09:00",
            "_service" => "PLUS",
            "_customer" => [
                "_name" => "Marcelo Santos",
                "_category" => "C",
                "_seat" => 8
            ],
            "_total" => "1214.00",
            "_tax" => "S",
            "_time_stamp" => "201407180914"
        ];

        $newTicket = TicketFactory::create($ticket);

        $this->assertEquals($ticket["_id"], $newTicket->getId());
        $this->assertEquals($ticket["_serie"], $newTicket->getSerie());
        $this->assertEquals($ticket["_from"], $newTicket->getFrom());
        $this->assertEquals($ticket["_vTO"], $newTicket->getTo());
        $this->assertEquals($ticket["_service"], $newTicket->getService());
        $this->assertEquals($ticket["_total"], $newTicket->getTotal());
        $this->assertEquals($ticket["_tax"], $newTicket->getTax());
        $this->assertEquals($ticket["_time_stamp"], $newTicket->getTimeStamp());

        $customer = $newTicket->getCustomer();
        $this->assertInstanceOf('Tufesa\Service\Type\Customer', $customer);
        $this->assertEquals($ticket["_customer"]["_name"], $customer->getName());
        $this->assertEquals($ticket["_customer"]["_category"], $customer->getCategory());
        $this->assertEquals($ticket["_customer"]["_seat"], $customer->getSeat());

        $departureDateTime = \DateTime::createFromFormat(
            "Ymd H:i",
            $ticket["_departure_date"] . " " . $ticket["_departure_time"]
        );

        $this->assertEquals($departureDateTime, $newTicket->getDepartureDateTime());
    }
}
