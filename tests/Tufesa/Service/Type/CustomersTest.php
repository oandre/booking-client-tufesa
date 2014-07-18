<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Customers;

class CustomersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_append_an_invalid_customer_instance_should_rainse_an_exception()
    {
        $customers = new Customers();
        $customers->append(new \stdClass());
    }
}
