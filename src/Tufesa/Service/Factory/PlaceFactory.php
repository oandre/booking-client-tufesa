<?php

namespace Tufesa\Service\Factory;

use Guzzle\Common\Exception\InvalidArgumentException;
use Tufesa\Service\Type\Place;

class PlaceFactory {

    public static function create(array $placeArray) {

        if(empty($placeArray)) {
            throw new \InvalidArgumentException("Required value");
        }

        if(empty($placeArray["idField"])) {
            throw new \InvalidArgumentException("Id value is required");
        }

        if(empty($placeArray["descriptionField"])) {
            throw new \InvalidArgumentException("Description value is required");
        }

        $place = new Place();
        $place->setDescription($placeArray["descriptionField"]);
        $place->setId($placeArray["idField"]);

        return $place;
    }
} 