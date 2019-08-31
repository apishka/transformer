<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Lower;

/**
 * Lower sanitizer test
 */
class LowerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Lower
     */
    protected function prepareSanitizer(): Lower
    {
        return new Lower();
    }

    /**
     * Test null
     */
    public function testNull(): void
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
            'test',
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
