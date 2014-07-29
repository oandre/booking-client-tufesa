<?php

namespace Tufesa\Service;

use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
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

    /**
     * @var \Guzzle\Http\Message\Request
     */
    protected $lastRequest;

    /**
     * @var \Guzzle\Http\Message\Response
     */
    protected $lastResponse;

    public function __construct(GuzzleClient $client)
    {
         $this->guzzleClient = $client;
    }

    public function reverseTickets($folio) 
    {

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
        $this->setLastRequest($request);

        $response = $request->send();
        $this->setLastResponse($response);

        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        return true;
    }

    public function getDestinations($from) 
    {
        $params = array(
            "from" => $from
        );

        $request = $this->guzzleClient->get("destinations?" . http_build_query($params));
        $this->setLastRequest($request);

        $response = $request->send();
        $this->setLastResponse($response);
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

    public function getOrigins() 
    {
        $request = $this->guzzleClient->get("origins?");
        $this->setLastRequest($request);

        $response = $request->send();
        $this->setLastResponse($response);
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

    /**
     * @param string    $from
     * @param string    $to
     * @param \DateTime $date
     * @return \Tufesa\Service\Type\Schedules
     * @throws \Tufesa\Service\Exceptions\ResponseException
     */
    public function getSchedules($from, $to, \DateTime $date)
    {
        $params = [
            "from" => $from,
            "to" => $to,
            "date" => $date->format("Ymd")
        ];

        $request = $this->guzzleClient->get("schedules?" . http_build_query($params));
        $this->setLastRequest($request);

        $response = $request->send();
        $this->setLastResponse($response);
        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        return ScheduleFactory::create($resource["_Response"]["dataField"]);
    }

    public function getSeatMap($from, $to, $schedule)
    {
        $params = [
            "from" => $from,
            "to" => $to,
            "schedule" => $schedule
        ];

        $request = $this->guzzleClient->get("seats?" . http_build_query($params));
        $this->setLastRequest($request);

        $response = $request->send();
        $this->setLastResponse($response);
        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        $rows = $resource["_Response"]["dataField"][0]["_row"];

        return SeatMapFactory::create($rows);
    }

    /**
     * @param \Tufesa\Service\Type\BuyRequest $buyRequest
     * @return \Tufesa\Service\Type\BuyResponse
     * @throws \Tufesa\Service\Exceptions\ResponseException
     */
    public function buyTickets(BuyRequest $buyRequest)
    {
        $customers = "";

        foreach ($buyRequest->getCustomers() as $customer) {
            $customers .= "<customer><name>" . $customer->getName() . "</name><category>" . $customer->getCategory() . "</category><seat>" . $customer->getSeat() . "</seat></customer>" . PHP_EOL;
        }

        $requestFormat = <<<REQUEST
<?xml version="1.0" encoding="UTF-8"?>
<BUSDoc version="1.0">
    <request>
        <from>%s</from>
        <to>%s</to>
        <date>%s</date>
        <schedule>%s</schedule>
        <folio>%s</folio>
        <customers>%s</customers>
    </request>
</BUSDoc>
REQUEST;

        $body = sprintf(
            $requestFormat,
            $buyRequest->getFrom(),
            $buyRequest->getTo(),
            $buyRequest->getDate()->format("Ymd"),
            $buyRequest->getSchedule(),
            $buyRequest->getFolio(),
            $customers
        );

        $headers = [
            "Content-Type" => "text/xml",
            "Accept" => "text/json"
        ];

        $request = $this->guzzleClient->post("buy", $headers, $body);
        $this->setLastRequest($request);

        $response = $request->send();
        $this->setLastResponse($response);
        $resource = $response->json();

        if ($resource["_Response"]["resultField"]["_id"] != "00") {
            throw new ResponseException($resource["_Response"]["resultField"]["_message"]);
        }

        $tickets = $resource["_Response"]["dataField"][0]["_ticket"];

        return BuyResponseFactory::create($tickets);
    }

    /**
     * @param \Guzzle\Http\Message\Response $lastResponse
     */
    public function setLastResponse(Response $lastResponse)
    {
        $this->lastResponse = $lastResponse;
    }

    /**
     * @return \Guzzle\Http\Message\Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param \Guzzle\Http\Message\Request $lastRequest
     */
    public function setLastRequest(Request $lastRequest)
    {
        $this->lastRequest = $lastRequest;
    }

    /**
     * @return \Guzzle\Http\Message\Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }
}
