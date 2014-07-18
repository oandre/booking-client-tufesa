<?php

namespace Tufesa\Service\Type;

class Customer
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var int
     */
    protected $seat;

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $seat
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;
    }

    /**
     * @return int
     */
    public function getSeat()
    {
        return $this->seat;
    }
}
