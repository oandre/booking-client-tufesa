<?php

namespace Tufesa\Service\Type;

use Tufesa\Service\Type\Place;

class Places extends \ArrayObject
{
    public function append($place)
    {
        if (!$place instanceof Place) {
            throw new \InvalidArgumentException("An instance of Tufesa\\Service\\Type\\Place is required");
        }

        parent::append($place);
    }
}
