<?php

namespace Tufesa\Service;

use Tufesa\Service\Factory\ScheduleFactory;
use Guzzle\Http\Client as GuzzleClient;

class Client
{
    protected $guzzleClient;

    public function __construct(GuzzleClient $client)
    {
         $this->guzzleClient = $client;
    }

    public function getGuzzleClient()
    {
        return $this->guzzleClient;
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
