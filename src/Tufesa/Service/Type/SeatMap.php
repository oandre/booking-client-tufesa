<?php

namespace Tufesa\Service\Type;

use Tufesa\Service\Type\Row;

class SeatMap extends \ArrayObject
{
    public function append($row)
    {
        if (!$row instanceof Row) {
            throw new \InvalidArgumentException("An instance of Tufesa\\Service\\Type\\Row is required");
        }

        parent::append($row);
    }
}
