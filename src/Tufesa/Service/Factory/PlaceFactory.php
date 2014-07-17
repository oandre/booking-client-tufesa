<?php

namespace Tufesa\Service\Factory;

use Guzzle\Common\Exception\InvalidArgumentException;
use Tufesa\Service\Type\Place;

class PlaceFactory {

    public static function create(array $place) {

        if(empty($place)) {
            throw new \InvalidArgumentException("Required value");
        }

        if(empty($place["idField"])) {
            throw new \InvalidArgumentException("Id value is required");
        }

        if(empty($place["descriptionField"])) {
            throw new \InvalidArgumentException("Description value is required");
        }

        $newPlace = new Place();
        $newPlace->setDescription($place["descriptionField"]);
        $newPlace->setId($place["idField"]);

        return $newPlace;
    }
} 