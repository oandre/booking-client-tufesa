<?php

namespace Tufesa\Service\Type;

class BuyRequest
{
    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var int
     */
    protected $schedule;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $folio;

    /**
     * @var \Tufesa\Service\Type\Customer[]
     */
    protected $customers;

    /**
     * @param \Tufesa\Service\Type\Customer[] $customers
     */
    public function setCustomers($customers)
    {
        $this->customers = $customers;
    }

    /**
     * @return \Tufesa\Service\Type\Customer[]
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param int $folio
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;
    }

    /**
     * @return int
     */
    public function getFolio()
    {
        return $this->folio;
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
     * @param int $schedule
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return int
     */
    public function getSchedule()
    {
        return $this->schedule;
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
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
