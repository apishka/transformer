<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Upper;

/**
 * Upper transform test
 */
class UpperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Upper
     */
    protected function prepareSanitizer(): Upper
    {
        return new Upper();
    }

    /**
     * Test null
     */
    public function testNull()
    {
        $this->assertNull(
            $this->prepareSanitizer()->process(null)
        );
    }

    /**
     * Test string
     */
    public function testString(): void
    {
        $this->assertSame(
            '10',
            $this->prepareSanitizer()->process(10)
        );

        $this->assertSame(
            'TEST',
            $this->prepareSanitizer()->process('tEsT')
        );

        $this->assertSame(
            '',
            $this->prepareSanitizer()->process('')
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

        $assert = $this->prepareSanitizer();
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
            [STDOUT],
            [function () {}],
            [new \StdClass()],
        ];
    }
}
