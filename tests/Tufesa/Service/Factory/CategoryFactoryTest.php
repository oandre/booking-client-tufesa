<?php

namespace Tufesa\Service\Factory;

class CategoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_id_should_raise_an_exception()
    {
        $category = [
            "_id" => ""
        ];

        CategoryFactory::create($category);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_value_should_raise_an_exception()
    {
        $category = [
            "_id" => 1234,
            "_value" => ""
        ];

        CategoryFactory::create($category);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_invalid_remain_should_raise_an_exception()
    {
        $category = [
            "_id" => 1234,
            "_value" => "VALUE",
            "_remain" => "INVALID"
        ];

        CategoryFactory::create($category);
    }

    public function test_method_create_should_return_a_valid_category_instance()
    {
        $category = [
            "_id" => 1234,
            "_value" => "VALUE",
            "_remain" => 3
        ];

        $newCategory = CategoryFactory::create($category);
        $this->assertInstanceOf('Tufesa\Service\Type\Category', $newCategory);
        $this->assertEquals($category["_id"], $newCategory->getId());
        $this->assertEquals($category["_value"], $newCategory->getValue());
        $this->assertEquals($category["_remain"], $newCategory->getRemain());
    }
}
