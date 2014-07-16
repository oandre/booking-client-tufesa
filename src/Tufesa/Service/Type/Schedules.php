<?php

namespace Tufesa\Service\Type;

use Tufesa\Service\Type\Schedule;

class Schedules extends \ArrayObject
{
    public function append($schedule)
    {
        if (!$schedule instanceof Schedule) {
            throw new \InvalidArgumentException("An instance of Tufesa\\Service\\Type\\Schedule is required");
        }

        parent::append($schedule);
    }
}
