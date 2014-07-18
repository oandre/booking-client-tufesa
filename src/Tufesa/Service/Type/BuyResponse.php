<?php

namespace Tufesa\Service\Type;

class BuyResponse extends \ArrayObject
{
    public function append($ticket)
    {
        if (!$ticket instanceof Ticket) {
            throw new \InvalidArgumentException("An instance of Tufesa\\Service\\Type\\Ticket is required");
        }

        parent::append($ticket);
    }
}
