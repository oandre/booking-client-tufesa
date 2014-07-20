<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Schedule;

class ScheduleFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_verify_required_inputs_should_work()
    {
        $schedule = [
            "_id" => "DUMMY",
            "_departure_date" => "DUMMY",
            "_departure_time" => "DUMMY",
            "_arrival_date" => "DUMMY",
            "_arrival_time" => "DUMMY",
            "_service" => "PRIMERA",
            "_category" => [[
                "_id" => 1234,
                "_value" => "VALUE",
                "_remain" => 3
            ]]
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    public function test_valid_data_should_work()
    {
        $busLine = "TUFES";

        $category = [
            "_id" => "ADULT",
            "_value" => "1234.00",
            "_remain" => 30
        ];

        $testSchedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
            "_arrival_date" => "20140715",
            "_arrival_time" => "18:00",
            "_service" => "PRIMERA",
            "_category" => [
                $category
            ]
        ];

        $data = [[
            "_line" => $busLine,
            "_schedules" => [
                $testSchedule
            ]
        ]];

        $schedulesCollection = ScheduleFactory::create($data);
        $this->assertInstanceOf('Tufesa\Service\Type\Schedules', $schedulesCollection);

        foreach ($schedulesCollection as $schedule) {
            $this->assertInstanceOf('Tufesa\Service\Type\Schedule', $schedule);
            $this->assertTrue(is_array($schedule->getCategories()));
            $this->assertEquals($busLine, $schedule->getBusLine());
            $this->assertEquals($testSchedule["_id"], $schedule->getId());
            $this->assertEquals($testSchedule["_service"], $schedule->getService());
            $scheduleCategory = $schedule->getCategoryByType($category["_id"]);

            $this->assertEquals($scheduleCategory->getId(), $category["_id"]);
            $this->assertEquals($scheduleCategory->getValue(), $category["_value"]);
            $this->assertEquals($scheduleCategory->getRemain(), $category["_remain"]);

            $departureDateTime = \DateTime::createFromFormat(
                'Ymd H:i',
                $testSchedule["_departure_date"] . " " . $testSchedule["_departure_time"]
            );

            $arrivalDateTime = \DateTime::createFromFormat(
                'Ymd H:i',
                $testSchedule["_arrival_date"] . " " . $testSchedule["_arrival_time"]
            );

            $this->assertEquals($departureDateTime, $schedule->getDepartureDateTime());
            $this->assertEquals($arrivalDateTime, $schedule->getArrivalDateTime());

            if (is_array($schedule->getCategories())) {
                foreach ($schedule->getCategories() as $category) {
                    $this->assertInstanceOf('Tufesa\Service\Type\Category', $category);
                }
            }
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_id_is_not_set()
    {
        $schedule = [
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
            "_arrival_date" => "20140715",
            "_arrival_time" => "18:00",
            "_service" => "PRIMERA",
            "_category" => [[
                "_id" => 1234,
                "_value" => "VALUE",
                "_remain" => 3
            ]]
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_departure_date_is_not_set()
    {
        $schedule = [
            "_id" => 1234
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_departure_time_is_not_set()
    {
        $schedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_arrival_date_is_not_set()
    {
        $schedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_arrival_time_is_not_set()
    {
        $schedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
            "_arrival_date" => "20140715",
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_service_is_not_set()
    {
        $schedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
            "_arrival_date" => "20140715",
            "_arrival_time" => "18:00",
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_category_is_not_set()
    {
        $schedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
            "_arrival_date" => "20140715",
            "_arrival_time" => "18:00",
            "_service" => "PRIMERA",
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_verify_required_fields_should_raise_an_exception_if_the_category_is_empty()
    {
        $schedule = [
            "_id" => 1234,
            "_departure_date" => "20140715",
            "_departure_time" => "15:00",
            "_arrival_date" => "20140715",
            "_arrival_time" => "18:00",
            "_service" => "PRIMERA",
            "_category" => []
        ];

        ScheduleFactory::verifyRequiredFields($schedule);
    }

    /**
     * @expectedException Exception
     */
    public function test_category_not_found_should_raise_an_exception()
    {
        $schedule = new Schedule();
        $schedule->setCategories([]);
        $schedule->getCategoryByType("ADULT");
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider invalidScheduleProvider
     */
    public function test_invalid_data_should_raise_an_exception($data)
    {
        ScheduleFactory::create($data);
    }

    public function invalidScheduleProvider()
    {
        return [
            [[[
                "_line" => "TUFES",
                "_schedules" => [[
                    "_id" => "INVALID ID",
                    "_departure_date" => "20140715",
                    "_departure_time" => "15:00",
                    "_arrival_date" => "20140715",
                    "_arrival_time" => "18:00",
                    "_service" => "PRIMERA",
                    "_category" => [[
                        "_id" => 1234,
                        "_value" => "VALUE",
                        "_remain" => 3
                    ]]
                ]]
            ]]],
            [[[
                "_line" => "TUFES",
                "_schedules" => [[
                    "_id" => 1234,
                    "_departure_date" => "2014-07-15",
                    "_departure_time" => "15:00",
                    "_arrival_date" => "20140715",
                    "_arrival_time" => "18:00",
                    "_service" => "PRIMERA",
                    "_category" => [[
                        "_id" => 1234,
                        "_value" => "VALUE",
                        "_remain" => 3
                    ]]
                ]]
            ]]],
            [[[
                "_line" => "TUFES",
                "_schedules" => [[
                    "_id" => 1234,
                    "_departure_date" => "20140715",
                    "_departure_time" => "1500",
                    "_arrival_date" => "20140715",
                    "_arrival_time" => "18:00",
                    "_service" => "PRIMERA",
                    "_category" => [[
                        "_id" => 1234,
                        "_value" => "VALUE",
                        "_remain" => 3
                    ]]
                ]]
            ]]],
            [[[
                "_line" => "TUFES",
                "_schedules" => [[
                    "_id" => 1234,
                    "_departure_date" => "20140715",
                    "_departure_time" => "15:00",
                    "_arrival_date" => "2014-07-15",
                    "_arrival_time" => "18:00",
                    "_service" => "PRIMERA",
                    "_category" => [[
                        "_id" => 1234,
                        "_value" => "VALUE",
                        "_remain" => 3
                    ]]
                ]]
            ]]],
            [[[
                "_line" => "TUFES",
                "_schedules" => [[
                    "_id" => 1234,
                    "_departure_date" => "20140715",
                    "_departure_time" => "15:00",
                    "_arrival_date" => "20140715",
                    "_arrival_time" => "1800",
                    "_service" => "PRIMERA",
                    "_category" => [[
                        "_id" => 1234,
                        "_value" => "VALUE",
                        "_remain" => 3
                    ]]
                ]]
            ]]],
            [[[
                "_line" => "TUFES",
                "_schedules" => [[
                    "_id" => 1234,
                    "_departure_date" => "20140715",
                    "_departure_time" => "15:00",
                    "_arrival_date" => "20140715",
                    "_arrival_time" => "18:00",
                    "_service" => "",
                    "_category" => [[
                        "_id" => 1234,
                        "_value" => "VALUE",
                        "_remain" => 3
                    ]]
                ]]
            ]]]
        ];
    }
}
