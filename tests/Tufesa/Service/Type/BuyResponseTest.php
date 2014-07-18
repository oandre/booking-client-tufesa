<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\BuyResponse;

class BuyResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_append_an_invalid_ticket_instance_should_rainse_an_exception()
    {
        $buyResponse = new BuyResponse();
        $buyResponse->append(new \stdClass());
    }
}
