<?php

namespace Tufesa\Service\Type;

class Category
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $remain;

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $remain
     */
    public function setRemain($remain)
    {
        $this->remain = $remain;
    }

    /**
     * @return int
     */
    public function getRemain()
    {
        return $this->remain;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
