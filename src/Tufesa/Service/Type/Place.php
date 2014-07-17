<?php
/**
 * Created by PhpStorm.
 * User: betanzos
 * Date: 7/15/14
 * Time: 12:46 PM
 */

namespace Tufesa\Service\Type;


class Place {

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $description;

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

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

} 