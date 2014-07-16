<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Seat;
use Tufesa\Service\Type\Row;
use Tufesa\Service\Type\SeatMap;

class SeatMapFactory
{
    public static function createRow(array $seats)
    {
        $row = new Row();

        foreach ($seats as $seat) {
            $row->append(self::createSeat($seat));
        }

        return $row;
    }

    public static function createSeat(array $seat)
    {
        if (!isset($seat['_id'])) {
            throw new \InvalidArgumentException('The field id is required');
        }

        if (!isset($seat['_available'])) {
            throw new \InvalidArgumentException('The field available is required');
        }

        if (!is_int($seat['_id'])) {
            throw new \InvalidArgumentException('The field id must be an integer');
        }

        $newSeat = new Seat();
        $newSeat->setId($seat['_id']);
        $newSeat->setAvailable($seat['_available']);

        return $newSeat;
    }

    public static function create(array $rows)
    {
        $seatMap = new SeatMap();

        foreach ($rows as $row) {
            $seatMap->append(self::createRow($row["_seat"]));
        }

        return $seatMap;
    }
}
