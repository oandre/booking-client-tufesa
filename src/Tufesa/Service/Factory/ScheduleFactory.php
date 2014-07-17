<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Schedule;
use Tufesa\Service\Type\Schedules;

class ScheduleFactory
{
    /**
     * @param array $schedules
     * @return \Tufesa\Service\Type\Schedules
     */
    public static function create(array $schedules)
    {
        $schedulesCollection = new Schedules();

        foreach ($schedules as $schedule) {
            $schedulesCollection->append(self::createSchedule($schedule));
        }

        return $schedulesCollection;
    }

    /**
     * @return \Tufesa\Service\Type\Schedule
     */
    public static function createSchedule(array $schedule)
    {
        self::verifyRequiredFields($schedule);

        if (!is_int($schedule["_id"])) {
            throw new \InvalidArgumentException("The id must be a number");
        }

        $departureDateTime = \DateTime::createFromFormat(
            'Ymd H:i',
            $schedule["_departure_date"] . " " . $schedule["_departure_time"]
        );

        if (!$departureDateTime) {
            $message = "The departure date or time is invalid: ";
            $message .= $schedule["_departure_date"] . " " . $schedule["_departure_time"];

            throw new \InvalidArgumentException($message);
        }

        $arrivalDateTime = \DateTime::createFromFormat(
            'Ymd H:i',
            $schedule["_arrival_date"] . " " . $schedule["_arrival_time"]
        );

        if (!$arrivalDateTime) {
            $message = "The arrival date or time is invalid: ";
            $message .= $schedule["_arrival_date"] . " " . $schedule["_arrival_time"];

            throw new \InvalidArgumentException($message);
        }

        if (empty($schedule["_service"])) {
            throw new \InvalidArgumentException("The service is required");
        }

        $newSchedule = new Schedule();
        $newSchedule->setId($schedule["_id"]);
        $newSchedule->setDepartureDateTime($departureDateTime);
        $newSchedule->setArrivalDateTime($arrivalDateTime);
        $newSchedule->setService($schedule["_service"]);

        $categories = array();

        foreach ($schedule["_category"] as $category) {
            $categories[] = CategoryFactory::create($category);
        }

        $newSchedule->setCategories($categories);

        return $newSchedule;
    }

    public static function verifyRequiredFields(array $schedule)
    {
        if (!isset($schedule["_id"])) {
            throw new \InvalidArgumentException("The field _id is required");
        }

        if (!isset($schedule["_departure_date"])) {
            throw new \InvalidArgumentException("The field _departure_date is required");
        }

        if (!isset($schedule["_departure_time"])) {
            throw new \InvalidArgumentException("The field _departure_time is required");
        }

        if (!isset($schedule["_arrival_date"])) {
            throw new \InvalidArgumentException("The field _arrival_date is required");
        }

        if (!isset($schedule["_arrival_time"])) {
            throw new \InvalidArgumentException("The field _arrival_time is required");
        }

        if (!isset($schedule["_service"])) {
            throw new \InvalidArgumentException("The field _service is required");
        }

        if (!isset($schedule["_category"])) {
            throw new \InvalidArgumentException("The field _category is required");
        }

        if (count($schedule["_category"]) == 0) {
            throw new \InvalidArgumentException("At least one category is required");
        }
    }
}
