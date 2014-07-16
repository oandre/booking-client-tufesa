<?php

namespace Tufesa\Service\Type;

use Tufesa\Service\Type\Seat;

class Row extends \ArrayObject
{
    public function append($seat)
    {
        if (!$seat instanceof Seat) {
            throw new \InvalidArgumentException("An instance of Tufesa\\Service\\Type\\Seat is required");
        }

        parent::append($seat);
    }
}
