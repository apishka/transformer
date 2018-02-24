<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\ArrayKeyExists;

/**
 * Array key exists test
 */
class ArrayKeyExistsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @param array $options
     *
     * @return ArrayKeyExists
     */
    protected function prepareAssert(array $options = [])
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
        return [
            [1, ['test' => 'test']],
            [1.2, ['test' => 'test']],
            [true, ['test' => 'test']],
            ['test', ['test1' => 'test1']],
            [function () {}, ['test' => 'test']],
            [new \StdClass(), ['test' => 'test']],
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
        return [
            [1, ['1' => 'test']],
            [1.2, ['1.2' => 'test']],
            [true, ['1' => 'test']],
            ['test', ['test' => 'test1']],
            ['test', function () {return ['test' => 123]; }],
        ];
    }
}
