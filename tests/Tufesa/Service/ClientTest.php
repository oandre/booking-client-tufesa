<?php

namespace Tufesa\Service;

use Guzzle\Http\Client as GuzzleClient;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function test_reserve_ticket_should_work_fine() {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":"983893727","resultField":{"_id":"00","_message":"Reversa Exitosa"},"dataField":null},"_Request":null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $folio = 829;
        $tufesaClient->reverseTickets($folio);
    }

    /**
     * @expectedException Tufesa\Service\Exceptions\ResponseException
     */
    public function test_reserve_ticket_should_send_unexisting_request() {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id": "1.0","_Response": {"_revAuth": "0","resultField": {"_id": "12","_message": "Referencia Autorizacion Invalida"},"dataField": null},"_Request": null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $folio = 829;
        $tufesaClient->reverseTickets($folio);
    }

    public function test_place_factory_with_unexitent_destinations() {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Consulta Exitosa"},"dataField":[{"_line":"TUFES","_point":[{"idField":"ACP","descriptionField":"Acaponeta"}],"_schedules":null,"_row":null,"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $from = "YHK";

        $places = $tufesaClient->getDestinations($from);

        $this->assertInstanceOf('Tufesa\Service\Type\Places', $places);
    }

    public function test_place_factory_should_return_an_instance_of_places() {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Consulta Exitosa"},"dataField":[{"_line":"TUFES","_point":[{"idField":"ACP","descriptionField":"Acaponeta"}],"_schedules":null,"_row":null,"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $from = "GDL";

        $places = $tufesaClient->getDestinations($from);

        $this->assertInstanceOf('Tufesa\Service\Type\Places', $places);
    }

    /**
     * @expectedException Tufesa\Service\Exceptions\ResponseException
     */
    public function test_problem_with_tufesa_get_destinations_should_raise_an_exception()
    {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id": "1.0", "_Response": { "_revAuth": null, "resultField": { "_id": "666", "_message": "SOME DUMMY MESSAGE HERE" } } }');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $from = "GDL";

        $places = $tufesaClient->getDestinations($from);

    }

    public function test_get_origins_should_return_an_instance_of_places() {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Consulta Exitosa"},"dataField":[{"_line":"TUFES","_point":[{"idField":"ACP","descriptionField":"Acaponeta"},{"idField":"AIT","descriptionField":"Aeropuerto Inter Tijuana"},{"idField":"AGP","descriptionField":"Agua Prieta"},{"idField":"BAK","descriptionField":"Bakersfield California"},{"idField":"BLL","descriptionField":"Bullhead City"},{"idField":"CAB","descriptionField":"Caborca"},{"idField":"CAN","descriptionField":"Cananea"},{"idField":"OBR","descriptionField":"Cd. Obregon"},{"idField":"COL","descriptionField":"Colton"},{"idField":"CUL","descriptionField":"Culiacan"},{"idField":"ROS","descriptionField":"El Rosario"},{"idField":"EMP","descriptionField":"Empalme"},{"idField":"EPZ","descriptionField":"Esperanza"},{"idField":"FRE","descriptionField":"Fresno California"},{"idField":"GIL","descriptionField":"Gilroy California"},{"idField":"GDL","descriptionField":"Guadalajara"},{"idField":"GMH","descriptionField":"Guamuchil"},{"idField":"GVE","descriptionField":"Guasave"},{"idField":"GYM","descriptionField":"Guaymas"},{"idField":"HMO","descriptionField":"Hermosillo"},{"idField":"HMA","descriptionField":"Hermosillo Aeropuerto"},{"idField":"HPK","descriptionField":"Huntington Park"},{"idField":"IMU","descriptionField":"Imuris"},{"idField":"IDO","descriptionField":"Indio California"},{"idField":"IXT","descriptionField":"Ixtlan"},{"idField":"KNG","descriptionField":"Kingman Arizona"},{"idField":"VEG","descriptionField":"Las Vegas"},{"idField":"LAU","descriptionField":"Laughlin Nevada"},{"idField":"LAD","descriptionField":"Los Angeles Downtown"},{"idField":"LAN","descriptionField":"Los Angeles East"},{"idField":"LBN","descriptionField":"Los Baños California"},{"idField":"MOC","descriptionField":"Los Mochis"},{"idField":"MAG","descriptionField":"Magdalena"},{"idField":"MAZ","descriptionField":"Mazatlan"},{"idField":"MER","descriptionField":"Merced California"},{"idField":"MXL","descriptionField":"Mexicali"},{"idField":"NAV","descriptionField":"Navojoa"},{"idField":"NOG","descriptionField":"Nogales"},{"idField":"NAZ","descriptionField":"Nogales Arizona"},{"idField":"ONT","descriptionField":"Ontario"},{"idField":"PNA","descriptionField":"Peñas"},{"idField":"PHX","descriptionField":"Phoenix"},{"idField":"SJS","descriptionField":"San Jose Califonia"},{"idField":"SLR","descriptionField":"San Luis Rio Colorado"},{"idField":"SYS","descriptionField":"San Ysidro CA"},{"idField":"STA","descriptionField":"Santa Ana"},{"idField":"STN","descriptionField":"Santa Ana Norte"},{"idField":"SNY","descriptionField":"Sonoyta"},{"idField":"TEP","descriptionField":"Tepic"},{"idField":"TIJ","descriptionField":"Tijuana Buenavista"},{"idField":"TJI","descriptionField":"Tijuana Insurgentes"},{"idField":"TUC","descriptionField":"Tucson"},{"idField":"TUL","descriptionField":"Tulare"},{"idField":"VIC","descriptionField":"Vicam"},{"idField":"VUN","descriptionField":"Villa Union"},{"idField":"ZAP","descriptionField":"Zapopan"}],"_schedules":null,"_row":null,"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $places = $tufesaClient->getOrigins();

        $this->assertTrue(is_array($places));
    }

    /**
     * @expectedException Tufesa\Service\Exceptions\ResponseException
     */
    public function test_problem_with_tufesa_get_origins_should_raise_an_exception()
    {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id": "1.0", "_Response": { "_revAuth": null, "resultField": { "_id": "666", "_message": "SOME DUMMY MESSAGE HERE" } } }');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzuleClient = new GuzzleClient();
        $guzzuleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzuleClient);

        $places = $tufesaClient->getOrigins();
    }

    public function test_schedule_factory_return_an_instance_of_schedule()
    {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Consulta Exitosa"},"dataField":[{"_line":"TUFES","_point":null,"_schedules":[{"_id":866940,"_departure_date":"20140716","_departure_time":"08:00","_arrival_date":"20140716","_arrival_time":"22:40","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":42},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":42},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865850,"_departure_date":"20140716","_departure_time":"09:00","_arrival_date":"20140716","_arrival_time":"23:30","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":40},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":40},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":866948,"_departure_date":"20140716","_departure_time":"14:30","_arrival_date":"20140717","_arrival_time":"05:30","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":35},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":35},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865860,"_departure_date":"20140716","_departure_time":"19:00","_arrival_date":"20140717","_arrival_time":"09:40","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":42},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":42},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":873811,"_departure_date":"20140716","_departure_time":"22:00","_arrival_date":"20140717","_arrival_time":"12:45","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":36},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":36},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":873824,"_departure_date":"20140716","_departure_time":"23:59","_arrival_date":"20140717","_arrival_time":"15:00","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":40},{"_id":"I","_value":"607.00","_remain":2},{"_id":"M","_value":"607.00","_remain":20},{"_id":"E","_value":"971.00","_remain":40},{"_id":"P","_value":"971.00","_remain":10}]},{"_id":865857,"_departure_date":"20140716","_departure_time":"23:59","_arrival_date":"20140717","_arrival_time":"15:00","_service":"PLUS","_category":[{"_id":"C","_value":"1214.00","_remain":0},{"_id":"I","_value":"607.00","_remain":0},{"_id":"M","_value":"607.00","_remain":0},{"_id":"E","_value":"971.00","_remain":0},{"_id":"P","_value":"971.00","_remain":0}]}],"_row":null,"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzleClient = new GuzzleClient();
        $guzzleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzleClient);

        $from = "GDL";
        $to = "OBR";
        $date = new \DateTime("tomorrow");

        $schedules = $tufesaClient->getSchedules($from, $to, $date);

        foreach ($schedules as $schedule) {
            $this->assertInstanceOf('Tufesa\Service\Type\Schedule', $schedule);
        }
    }

    /**
     * @expectedException Tufesa\Service\Exceptions\ResponseException
     */
    public function test_problem_with_tufesa_get_schedules_should_raise_an_exception()
    {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id": "1.0", "_Response": { "_revAuth": null, "resultField": { "_id": "666", "_message": "SOME DUMMY MESSAGE HERE" } } }');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzleClient = new GuzzleClient();
        $guzzleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzleClient);

        $from = "GDL";
        $to = "OBR";
        $date = new \DateTime("tomorrow");

        $schedules = $tufesaClient->getSchedules($from, $to, $date);
    }

    public function test_seat_map_factory_should_return_an_instance_of_seat_map()
    {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id":"1.0","_Response":{"_revAuth":null,"resultField":{"_id":"00","_message":"Mensaje Exitoso"},"dataField":[{"_line":"TUFES","_point":null,"_schedules":null,"_row":[{"_seat":[{"_id":4,"_available":true},{"_id":8,"_available":true},{"_id":12,"_available":true},{"_id":16,"_available":true},{"_id":20,"_available":true},{"_id":24,"_available":true},{"_id":28,"_available":true},{"_id":32,"_available":true},{"_id":36,"_available":true},{"_id":40,"_available":true}]},{"_seat":[{"_id":3,"_available":true},{"_id":7,"_available":true},{"_id":11,"_available":true},{"_id":15,"_available":true},{"_id":19,"_available":true},{"_id":23,"_available":true},{"_id":27,"_available":true},{"_id":31,"_available":true},{"_id":35,"_available":true},{"_id":39,"_available":true}]},{"_seat":[{"_id":2,"_available":true},{"_id":6,"_available":true},{"_id":10,"_available":true},{"_id":14,"_available":true},{"_id":18,"_available":true},{"_id":22,"_available":true},{"_id":26,"_available":true},{"_id":30,"_available":true},{"_id":34,"_available":true},{"_id":38,"_available":true}]},{"_seat":[{"_id":1,"_available":true},{"_id":5,"_available":true},{"_id":9,"_available":true},{"_id":13,"_available":true},{"_id":17,"_available":true},{"_id":21,"_available":true},{"_id":25,"_available":true},{"_id":29,"_available":true},{"_id":33,"_available":true},{"_id":37,"_available":true}]}],"_total_trans":null,"_auth":null,"_ticket":null}]},"_Request":null}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzleClient = new GuzzleClient();
        $guzzleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzleClient);

        $from = "GDL";
        $to = "OBR";
        $schedule = 866926;

        $seatMap = $tufesaClient->getSeatMap($from, $to, $schedule);
        $this->assertInstanceOf('Tufesa\Service\Type\SeatMap', $seatMap);
    }

    /**
     * @expectedException Tufesa\Service\Exceptions\ResponseException
     */
    public function test_problem_with_tufesa_get_seat_map_should_raise_an_exception()
    {
        $response = new \Guzzle\Http\Message\Response(200);
        $response->setBody('{"_id": "1.0", "_Response": { "_revAuth": null, "resultField": { "_id": "666", "_message": "SOME DUMMY MESSAGE HERE" }}}');

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $guzzleClient = new GuzzleClient();
        $guzzleClient->addSubscriber($plugin);

        $tufesaClient = new Client($guzzleClient);

        $from = "GDL";
        $to = "OBR";
        $schedule = 866926;

        $seatMap = $tufesaClient->getSeatMap($from, $to, $schedule);
        $this->assertInstanceOf('Tufesa\Service\Type\SeatMap', $seatMap);
    }
}
