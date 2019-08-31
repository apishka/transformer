<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\FloatType;

/**
 * Float type assert test
 */
class FloatTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return FloatType
     */
    protected function prepareAssert(): FloatType
    {
        return new FloatType();
    }

    /**
     * Test float
     */
    public function testFloat(): void
    {
        $this->assertSame(
            7.4,
            $this->prepareAssert()->process(7.4)
        );

        $this->assertSame(
            0.0,
            $this->prepareAssert()->process(0)
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
            ['test'],
            [function () {}],
            [new \StdClass()],
        ];
    }

    /**
     * Test with filters
     */
    public function testWithFilters(): void
    {
        $this->assertSame(
            1123123.123,
            $this->prepareAssert()->process('1 123 123.123')
        );
    }

    /**
     * Test without filters
     */
    public function testWithoutFilters(): void
    {
        $this->assertSame(
            1.0,
            $this->prepareAssert()->process(
                '1 123 123.123',
                [
                    'apply_filters' => false,
                ]
            )
        );
    }
}
