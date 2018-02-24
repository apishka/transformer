<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\ArrayIntersect;

/**
 * Array key exists test
 */
class ArrayIntersectTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @param array $options
     *
     * @return ArrayIntersect
     */
    protected function prepareAssert(array $options = [])
    {
        return new ArrayIntersect($options);
    }

    /**
     * Test array
     */
    public function testArray()
    {
        $this->assertSame(
            [10],
            $this->prepareAssert()->process([10], ['values' => [10]])
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
        return [
            [[1], ['test']],
            [[1.2], ['test']],
            [[true], ['test']],
            [['test'], ['test1']],
            [function () {}, ['test']],
            [new \StdClass(), ['test']],
        ];
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
        return [
            [[1], ['1']],
            [[1.2], ['1.2']],
            [[true], ['1']],
            [['test'], ['test']],
            [['test'], function () {return ['test']; }],
        ];
    }
}
