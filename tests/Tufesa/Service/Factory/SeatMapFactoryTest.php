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

        $newSeat = SeatMapFactory::createSeat($seat);

        $this->assertInstanceOf('Tufesa\Service\Type\Seat', $newSeat);
        $this->assertEquals($seat["_id"], $newSeat->getId());
        $this->assertEquals($seat["_available"], $newSeat->getAvailable());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_seat_without_the_id_field_should_raise_an_exception()
    {
        $seat = [
            "_available" => true
        ];

        SeatMapFactory::createSeat($seat);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_seat_with_invalid_id_field_should_raise_an_exception()
    {
        $seat = [
            "_id" => new \StdClass(),
            "_available" => true
        ];

        SeatMapFactory::createSeat($seat);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_create_seat_without_the_available_field_should_raise_an_exception()
    {
        $seat = [
            "_id" => 1234
        ];

        SeatMapFactory::createSeat($seat);
    }
}
