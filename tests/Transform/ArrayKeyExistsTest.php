<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\ArrayKeyExists;

/**
 * Array key exists test
 */

class ArrayKeyExistsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return ArrayKeyExists
     */

    protected function prepareAssert()
    {
        return new ArrayKeyExists($options);
    }

    /**
     * Test array
     */

    public function testArray()
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(10, ['values' => [10 => null]])
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
            array(1, ['test' => 'test']),
            array(1.2, ['test' => 'test']),
            array(true, ['test' => 'test']),
            array('test', ['test1' => 'test1']),
            array(function () {}, ['test' => 'test']),
            array(new \StdClass(), ['test' => 'test']),
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
        $this->assertSame(
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
            array(1, ['1' => 'test']),
            array(1.2, ['1.2' => 'test']),
            array(true, ['1' => 'test']),
            array('test', ['test' => 'test1']),
            array('test', function () {return array('test' => 123);}),
        );
    }
}
