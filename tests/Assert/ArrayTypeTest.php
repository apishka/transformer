<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\ArrayType;

/**
 * Array type assert test
 */

class ArrayTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return ArrayType
     */

    protected function prepareAssert()
    {
        return new ArrayType();
    }

    /**
     * Test array
     */

    public function testArray()
    {
        $this->assertSame(
            array(1),
            $this->prepareAssert()->process(array(1))
        );
    }

    /**
     * Test null
     */

    public function testNull()
    {
        $this->assertSame(
            null,
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test wrong types
     * @dataProvider             wrongValuesProvider
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testWrongValues($wrong_type)
    {
        $assert = $this->prepareAssert();
        $assert->process($wrong_type);
    }

    /**
     * Wrong data provider
     * @return array
     */

    public function wrongValuesProvider()
    {
        return array(
            array(1),
            array(1.2),
            array(true),
            array('test'),
            array(function(){}),
            array(new \StdClass())
        );
    }
}