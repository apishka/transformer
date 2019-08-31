<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\StringType;

/**
 * String type assert test
 */
class StringTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return StringType
     */
    protected function prepareAssert(): StringType
    {
        return new StringType();
    }

    /**
     * Test string
     */
    public function testString(): void
    {
        $this->assertSame(
            'test',
            $this->prepareAssert()->process('test')
        );

        $this->assertSame(
            '1',
            $this->prepareAssert()->process(1)
        );

        $this->assertSame(
            '1.2',
            $this->prepareAssert()->process(1.2)
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
            [[]],
            [function () {}],
            [new \StdClass()],
        ];
    }
}
