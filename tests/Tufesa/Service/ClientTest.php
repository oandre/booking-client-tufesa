<?php

namespace Tufesa\Service;

use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Client as GuzzleClient;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function test_schedule_factory_return_a_instance_of_schedule()
    {
        $response = new Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Consulta Exitosa"},"dataField":[{"_line":"TUFES","_point":null,"_schedules":[{"_id":866940,"_departure_date":"20140716","_departure_time":"08:00","_arrival_date":"20140716","_arrival_time":"22:40","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":42},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":42},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865850,"_departure_date":"20140716","_departure_time":"09:00","_arrival_date":"20140716","_arrival_time":"23:30","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":40},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":40},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":866948,"_departure_date":"20140716","_departure_time":"14:30","_arrival_date":"20140717","_arrival_time":"05:30","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":35},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":35},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865860,"_departure_date":"20140716","_departure_time":"19:00","_arrival_date":"20140717","_arrival_time":"09:40","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":42},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":42},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":873811,"_departure_date":"20140716","_departure_time":"22:00","_arrival_date":"20140717","_arrival_time":"12:45","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":36},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":36},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":873824,"_departure_date":"20140716","_departure_time":"23:59","_arrival_date":"20140717","_arrival_time":"15:00","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":40},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":40},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865857,"_departure_date":"20140716","_departure_time":"23:59","_arrival_date":"20140717","_arrival_time":"15:00","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":0},{"_id":"I","_value":"607.00","_remain":0},{"_id":"M","_value":"607.00","_remain":0},{"_id":"E","_value":"971.00","_remain":0},{"_id":"P","_value":"971.00","_remain":0}]}],"_row":null,"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}');

        $plugin = new MockPlugin();
        $plugin->addResponse($response);
        $guzzleClient = new GuzzleClient();
        $guzzleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzleClient);

        $from = "GDL";
        $to = "OBR";
        $date = new \DateTime("tomorrow");

        $schedules = $tufesaClient->getSchedules($from, $to, $date);

        $this->assertTrue(is_array($schedules));

        foreach ($schedules as $schedule) {
            $this->assertInstanceOf('Tufesa\Service\Type\Schedule', $schedule);
        }
    }
}
