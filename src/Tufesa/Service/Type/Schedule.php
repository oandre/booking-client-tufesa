<?php

namespace Tufesa\Service\Type;

class Schedule
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $departureDateTime;

    /**
     * @var \DateTime
     */
    protected $arrivalDateTime;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @param \DateTime $arrivalDateTime
     */
    public function setArrivalDateTime($arrivalDateTime)
    {
        $this->arrivalDateTime = $arrivalDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getArrivalDateTime()
    {
        return $this->arrivalDateTime;
    }

    /**
     * @param \Tufesa\Service\Type\Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return \Tufesa\Service\Type\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \DateTime $departureDateTime
     */
    public function setDepartureDateTime($departureDateTime)
    {
        $this->departureDateTime = $departureDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getDepartureDateTime()
    {
        return $this->departureDateTime;
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

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }
}
