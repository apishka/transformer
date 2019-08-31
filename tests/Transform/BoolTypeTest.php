<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\BoolType;

/**
 * Bool type assert test
 */
class BoolTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return BoolType
     */
    protected function prepareAssert(): BoolType
    {
        return new BoolType();
    }

    /**
     * Test valid data
     */
    public function testValid(): void
    {
        $this->assertSame(
            1,
            $this->prepareAssert()->process('test')
        );

        $this->assertSame(
            1,
            $this->prepareAssert()->process(2)
        );

        $this->assertSame(
            0,
            $this->prepareAssert()->process(0)
        );

        $this->assertSame(
            0,
            $this->prepareAssert()->process(false)
        );

        $this->assertSame(
            0,
            $this->prepareAssert()->process('0')
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
     * Test wrong values
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
            [STDOUT],
            [function () {}],
            [new \StdClass()],
        ];
    }
}
