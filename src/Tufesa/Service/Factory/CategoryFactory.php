<?php

namespace Tufesa\Service\Factory;

use Tufesa\Service\Type\Category;

class CategoryFactory
{
    /**
     * @return \Tufesa\Service\Type\Category
     */
    public static function create(array $category)
    {
        if (empty($category["_id"])) {
            throw new \InvalidArgumentException("The id is required");
        }

        if (empty($category["_value"])) {
            throw new \InvalidArgumentException("The value is required");
        }

        if (!is_int($category["_remain"])) {
            throw new \InvalidArgumentException("The remain must be a number");
        }

        $newCategory = new Category();
        $newCategory->setId($category["_id"]);
        $newCategory->setValue($category["_value"]);
        $newCategory->setRemain($category["_remain"]);

        return $newCategory;
    }
}
