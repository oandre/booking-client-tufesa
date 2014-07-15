<?php

namespace Tufesa\Service;

use Tufesa\Service\Factory\ScheduleFactory;

class Client
{
    protected $client;

    public function __construct($url, $token)
    {
         $this->client = new \Guzzle\Http\Client($url . "/" . $token);
    }

    public function getSchedules($from, $to, \DateTime $date)
    {
        $resource = json_decode('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Consulta Exitosa"},"dataField":[{"_line":"TUFES","_point":null,"_schedules":[{"_id":866926,"_departure_date":"20140715","_departure_time":"08:00","_arrival_date":"20140715","_arrival_time":"22:40","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":40},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":40},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865827,"_departure_date":"20140715","_departure_time":"09:00","_arrival_date":"20140715","_arrival_time":"23:30","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":41},{"_id":"I","_value":"607.00","_remain":1},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":41},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":866934,"_departure_date":"20140715","_departure_time":"14:30","_arrival_date":"20140716","_arrival_time":"05:30","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":37},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":37},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865837,"_departure_date":"20140715","_departure_time":"19:00","_arrival_date":"20140716","_arrival_time":"09:40","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":40},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":40},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865834,"_departure_date":"20140715","_departure_time":"23:59","_arrival_date":"20140716","_arrival_time":"15:00","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":42},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":42},{"_id":"P","_value":"971.00","_remain":10}]}],"_row":null,"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}', true);

        $params = [
            "from" => $from,
            "to" => $to,
            "date" => $date->format("Ymd")
        ];

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new \Exception($resource["_Response"]["resultField"]["_message"]);
        }

        $schedules = array();

        foreach ($resource["_Response"]["dataField"][0]["_schedules"] as $schedule)
        {
            $schedules[] = ScheduleFactory::create($schedule);
        }

        return $schedules;
    }

}
