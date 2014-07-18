<?php

namespace Tufesa\Service\Factory;

class BuyRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_from_should_raise_an_exception()
    {
        $ticket = [];

        BuyRequestFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_to_should_raise_an_exception()
    {
        $ticket = [
            "from" => "GDL"
        ];

        BuyRequestFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_date_should_raise_an_exception()
    {
        $ticket = [
            "from" => "GDL",
            "to" => "OBR"
        ];

        BuyRequestFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_schedule_should_raise_an_exception()
    {
        $ticket = [
            "from" => "GDL",
            "to" => "OBR",
            "date" => "20140720"
        ];

        BuyRequestFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_folio_should_raise_an_exception()
    {
        $ticket = [
            "from" => "GDL",
            "to" => "OBR",
            "date" => "20140720",
            "schedule" => 12345678
        ];

        BuyRequestFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_customers_should_raise_an_exception()
    {
        $ticket = [
            "from" => "GDL",
            "to" => "OBR",
            "date" => "20140720",
            "schedule" => 12345678,
            "folio" => 12345678
        ];

        BuyRequestFactory::validateRequiredFields($ticket);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_validate_required_fields_without_the_field_customers_beeing_an_array_should_raise_an_exception()
    {
        $ticket = [
            "from" => "GDL",
            "to" => "OBR",
            "date" => "20140720",
            "schedule" => 12345678,
            "folio" => 12345678,
            "customers" => new \StdClass()
        ];

        BuyRequestFactory::validateRequiredFields($ticket);
    }
}
