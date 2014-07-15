<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Schedule;

class ScheduleFactory
{
    /**
     * @return \Tufesa\Service\Type\Schedule
     */
    public static function create(array $schedule)
    {
        return new Schedule();
    }
}
