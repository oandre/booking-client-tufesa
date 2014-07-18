<?php

namespace Tufesa\Service\Factory;

class CustomerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_name_should_rise_an_exception()
    {
        CustomerFactory::create([]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_category_should_rise_and_exception()
    {
        $customer = [
            "name" => "Juan Perez",
        ];

        CustomerFactory::create($customer);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_seat_should_rise_and_exception()
    {
        $customer = [
            "name" => "Juan Perez",
            "category" => "C",
        ];

        CustomerFactory::create($customer);
    }

    public function test_create_with_valid_data_must_return_valid_customer_instance() {
        $customer = [
            "name" => "Juan Perez",
            "category" => "C",
            "seat" => 8
        ];

        $newCustomer = CustomerFactory::create($customer);
        $this->assertInstanceOf('Tufesa\Service\Type\Customer', $newCustomer);
        $this->assertEquals($customer["name"], $newCustomer->getName());
        $this->assertEquals($customer["category"], $newCustomer->getCategory());
        $this->assertEquals($customer["seat"], $newCustomer->getSeat());
    }
}
