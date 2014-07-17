<?php

namespace Tufesa\Service\Factory;

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
        $schedules = [[
            "_id" => 1234,
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
        ]];

        $schedulesCollection = ScheduleFactory::create($schedules);
        $this->assertInstanceOf('Tufesa\Service\Type\Schedules', $schedulesCollection);

        foreach ($schedulesCollection as $schedule) {
            $this->assertInstanceOf('Tufesa\Service\Type\Schedule', $schedule);
            $this->assertTrue(is_array($schedule->getCategories()));

            if (is_array($schedule->getCategories())) {
                foreach ($schedule->getCategories() as $category) {
                    $this->assertInstanceOf('Tufesa\Service\Type\Category', $category);
                }
            }
        }
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider invalidScheduleProvider
     */
    public function test_invalid_data_should_raise_an_exception($schedule)
    {
        ScheduleFactory::create($schedule);
    }

    public function invalidScheduleProvider()
    {
        return [
            [[[
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
            ]]],
            [[[
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
            ]]],
            [[[
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
            ]]],
            [[[
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
            ]]],
            [[[
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
            ]]],
            [[[
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
            ]]]
        ];
    }
}
