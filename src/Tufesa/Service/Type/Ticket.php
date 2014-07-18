<?php

namespace Tufesa\Service\Type;

class Ticket
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $serie;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var \DateTime
     */
    protected $departureDateTime;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var \Tufesa\Service\Type\Customer
     */
    protected $customer;

    /**
     * @var string
     */
    protected $total;

    /**
     * @var string
     */
    protected $tax;

    /**
     * @var string
     */
    protected $timeStamp;

    /**
     * @param \Tufesa\Service\Type\Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return \Tufesa\Service\Type\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
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
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
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
     * @param string $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
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

    /**
     * @param string $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param string $timeStamp
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * @return string
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }
}
