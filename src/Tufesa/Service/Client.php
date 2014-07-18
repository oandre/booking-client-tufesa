<?php

namespace Tufesa\Service;

use Tufesa\Service\Exceptions\ResponseException;
use Tufesa\Service\Factory\BuyResponseFactory;
use Tufesa\Service\Factory\PlaceFactory;
use Tufesa\Service\Factory\ScheduleFactory;
use Tufesa\Service\Factory\SeatMapFactory;
use Guzzle\Http\Client as GuzzleClient;
use Tufesa\Service\Type\BuyRequest;
use Tufesa\Service\Type\Places;
use Tufesa\Service\Type\SeatMap;

class Client
{
    protected $guzzleClient;

    public function __construct(GuzzleClient $client)
    {
         $this->guzzleClient = $client;
    }

    public function reverseTickets($folio) {

        if(empty($folio)) {
            throw new \InvalidArgumentException("Folio value is required");
        }

        if(!is_int($folio)) {
            throw new \InvalidArgumentException("Folio needs to be a numeric");
        }

        $params = [
            "folio" => $folio,
        ];

        $request = $this->guzzleClient->get("reverse?" . http_build_query($params));
        $response = $request->send();
        $resource = $response->json();


        if($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        } else {
            return true;
        }
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

    public function buyTickets(BuyRequest $buyRequest)
    {
        $customersXml = "";

        foreach ($buyRequest->getCustomers() as $customer) {
            $customersXml .= "
                <customer>
                    <name>" . $customer->getName() . "</name>
                    <category>" . $customer->getCategory() . "</category>
                    <seat>" . $customer->getSeat() . "</seat>
                </customer>
            ";
        }

        $body = "
            <?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <BUSDoc version=\"1.0\">
                <request>
                    <from>" . $buyRequest->getFrom() . "</from>
                    <to>" . $buyRequest->getTo() . "</to>
                    <date>" . $buyRequest->getDate()->format("Ymd") . "</date>
                    <schedule>" . $buyRequest->getSchedule() . "</schedule>
                    <folio>" . $buyRequest->getFolio() . "</folio>
                    <customers>" . $customersXml . "</customers>
                </request>
            </BUSDoc>
        ";

        $headers = [
            "Content-Type" => "text/xml"
        ];

        $request = $this->guzzleClient->get("buy", $headers, $body);
        $response = $request->send();
        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        $tickets = $resource["_Response"]["dataField"][0]["_ticket"];

        return BuyResponseFactory::create($tickets);
    }
}
