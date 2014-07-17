<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Schedules;

class SchedulesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_append_an_invalid_schedule_instance_should_rainse_an_exception()
    {
        $schedules = new Schedules();
        $schedule = new \stdClass();
        $schedules->append($schedule);
    }
}
