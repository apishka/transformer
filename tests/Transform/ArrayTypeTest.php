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
    protected function prepareAssert(): ArrayType
    {
        return new ArrayType();
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->assertSame(
            [1],
            $this->prepareAssert()->process([1])
        );
    }

    /**
     * Test null
     */
    public function testNull(): void
    {
        $this->assertNull(
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test wrong types
     *
     * @dataProvider             wrongValuesProvider
     * @param mixed $wrong_type
     */
    public function testWrongValues($wrong_type): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $assert = $this->prepareAssert();
        $assert->process($wrong_type);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */
    public function wrongValuesProvider(): array
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
