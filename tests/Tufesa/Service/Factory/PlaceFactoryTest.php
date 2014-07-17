<?php
/**
 * Created by PhpStorm.
 * User: betanzos
 * Date: 7/15/14
 * Time: 8:06 PM
 */

namespace Tufesa\Service\Factory;


class PlaceFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_id_should_rise_an_exception()
    {
        $place = [
            "idField" => ""
        ];

        PlaceFactory::create($place);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_description_should_rise_and_exception() {
        $place = [
            "idField" => "MEX",
            "descriptionField" => ""
        ];

        PlaceFactory::create($place);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_empty_array_should_rise_and_exception() {
        $place = array();

        PlaceFactory::create($place);
    }

    public function test_create_method_must_return_valid_place_instance() {
        $place = [
            "idField" => "OBR",
            "descriptionField" => "Cd. Obregon"
        ];

        $newPlace = PlaceFactory::create($place);
        $this->assertInstanceOf('Tufesa\Service\Type\Place', $newPlace);
        $this->assertEquals($place["idField"], $newPlace->getId());
        $this->assertEquals($place["descriptionField"], $newPlace->getDescription());
    }

} 