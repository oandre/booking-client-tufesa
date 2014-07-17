<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Places;

class PlacesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_append_an_invalid_place_instance_should_rainse_an_exception()
    {
        $places = new Places();
        $place = new \stdClass();
        $places->append($place);
    }
}
