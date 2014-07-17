<?php

namespace Tufesa\Service;

use Tufesa\Service\Exceptions\ResponseException;
use Tufesa\Service\Factory\PlaceFactory;
use Tufesa\Service\Factory\ScheduleFactory;
use Tufesa\Service\Factory\SeatMapFactory;
use Guzzle\Http\Client as GuzzleClient;
use Tufesa\Service\Type\Places;
use Tufesa\Service\Type\SeatMap;

class Client
{
    protected $guzzleClient;

    public function __construct(GuzzleClient $client)
    {
         $this->guzzleClient = $client;
    }

    public function getDestinations($from) {
        $params = array(
            "from" => $from
        );

        $request = $this->guzzleClient->get("destinations?" . http_build_query($params));
        $response = $request->send();
        $resource = $response->json();

        if($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        $places = new Places();

        foreach ($resource["_Response"]["dataField"][0]["_point"] as $place) {
            $places->append(PlaceFactory::create($place));
        }

        return $places;
    }

    public function getOrigins() {
        $request = $this->guzzleClient->get("origins?");
        $response = $request->send();
        $resource = $response->json();

        if($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        $places = array();

        foreach($resource["_Response"]["dataField"][0]["_point"] as $place) {
            $places[] = PlaceFactory::create($place);
        }

        return $places;
    }

    public function getSchedules($from, $to, \DateTime $date)
    {
        $params = [
            "from" => $from,
            "to" => $to,
            "date" => $date->format("Ymd")
        ];

        $request = $this->guzzleClient->get("schedules?" . http_build_query($params));
        $response = $request->send();
        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        return ScheduleFactory::create($resource["_Response"]["dataField"][0]["_schedules"]);
    }

    public function getSeatMap($from, $to, $schedule)
    {
        $params = [
            "from" => $from,
            "to" => $to,
            "schedule" => $schedule
        ];

        $request = $this->guzzleClient->get("seats?" . http_build_query($params));
        $response = $request->send();
        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        $rows = $resource["_Response"]["dataField"][0]["_row"];

        return SeatMapFactory::create($rows);
    }
}
