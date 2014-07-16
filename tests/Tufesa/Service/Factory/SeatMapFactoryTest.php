<?php

namespace Tufesa\Service\Factory;

class SeatMapFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_create_seat_with_valid_data_should_return_a_valid_instance_of_seat()
    {
        $seat = [
            "_id" => 1,
            "_available" => true
        ];

        $this->assertInstanceOf('Tufesa\Service\Type\Seat', SeatMapFactory::createSeat($seat));
    }
}
