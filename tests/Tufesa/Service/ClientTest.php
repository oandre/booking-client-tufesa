<?php

namespace Tufesa\Service;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function test_schedule_factory_return_a_instance_of_schedule()
    {
        $client = new Client("http://ventas.tufesa.com.mx/wsrestjson/", "tkntest2495340-2012");

        $from = "GDL";
        $to = "OBR";
        $date = new \DateTime("tomorrow");

        $this->assertEquals(count($client->getSchedules($from, $to, $date)), 5);
    }
}
