<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\ArrayType;

/**
 * Array type test
 */
class ArrayTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare array type
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
            [1],
            $this->prepareAssert()->process([1])
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
     * @param mixed $wrong_type
     */
    public function testWrongValues($wrong_type)
    {
        $assert = $this->prepareAssert();
        $assert->process($wrong_type);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */
    public function wrongValuesProvider()
    {
        return [
            [1],
            [1.2],
            [true],
            ['test'],
            [function () {}],
            [new \StdClass()],
        ];
    }
}
