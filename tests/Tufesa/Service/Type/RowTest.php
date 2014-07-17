<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Row;

class RowTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_append_an_invalid_seat_instance_should_rainse_an_exception()
    {
        $row = new Row();
        $seat = new \stdClass();
        $row->append($seat);
    }
}
