<?php

namespace Tufesa\Service\Type;

class Seat
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var boolean
     */
    protected $available;

    /**
     * @param mixed $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return boolean
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
