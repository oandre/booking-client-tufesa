<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\SeatMap;

class SeatMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_append_an_invalid_row_instance_should_rainse_an_exception()
    {
        $seatMap = new SeatMap();
        $row = new \stdClass();
        $seatMap->append($row);
    }
}
