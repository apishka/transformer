<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\ArrayIntersect;

/**
 * Array key exists test
 */

class ArrayIntersectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return ArrayIntersect
     */

    protected function prepareAssert()
    {
        return new ArrayIntersect($options);
    }

    /**
     * Test array
     */

    public function testArray()
    {
        $this->assertSame(
            array(10),
            $this->prepareAssert()->process(array(10), ['values' => [10]])
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
     *
     * @dataProvider             wrongValuesProvider
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     *
     * @param mixed $value
     * @param array $values
     */

    public function testWrongValues($value, array $values)
    {
        $assert = $this->prepareAssert();
        $assert->process($value, ['values' => $values]);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */

    public function wrongValuesProvider()
    {
        return array(
            array(array(1), ['test']),
            array(array(1.2), ['test']),
            array(array(true), ['test']),
            array(array('test'), ['test1']),
            array(function () {}, ['test']),
            array(new \StdClass(), ['test']),
        );
    }

    /**
     * Test good values
     *
     * @dataProvider             goodValuesProvider
     *
     * @param mixed $value
     * @param array $values
     */

    public function testGoodValues($value, $values)
    {
        $assert = $this->prepareAssert();
        $this->assertEquals(
            $value,
            $assert->process($value, ['values' => $values])
        );
    }

    /**
     * Good data provider
     *
     * @return array
     */

    public function goodValuesProvider()
    {
        return array(
            array(array(1), ['1']),
            array(array(1.2), ['1.2']),
            array(array(true), ['1']),
            array(array('test'), ['test']),
            array(array('test'), function () {return array('test');}),
        );
    }
}

