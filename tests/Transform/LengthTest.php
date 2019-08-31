<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Length;

/**
 * Length transform test
 */
class LengthTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Length
     */
    protected function prepareSanitizer(): Length
    {
        return new Length();
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
     * Test no options
     */
    public function testNoOptiopns(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Not found "min" or "max" in options');

        $this->prepareSanitizer()->process(10);
    }

    /**
     * Test good values
     *
     * @param mixed $expected
     * @param mixed $value
     * @param array $options
     *
     * @dataProvider             providerTestGoodValues
     */
    public function testGoodValues($expected, $value, array $options): void
    {
        $this->assertSame(
            $expected,
            $this->prepareSanitizer()->process($value, $options)
        );
    }

    /**
     * Provider test good values
     *
     * @return array
     */
    public function providerTestGoodValues(): array
    {
        return [
            [
                10,
                10,
                [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
            [
                10.0,
                10.0,
                [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
            [
                '10.0',
                '10.0',
                [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
        ];
    }

    /**
     * Test bad min values
     *
     * @param mixed $expected
     * @param mixed $value
     * @param array $options
     * @dataProvider badMinValuesProvider
     */
    public function testBadMinValues($expected, $value, array $options): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessageRegExp('#min \d+ characters#');

        $this->assertSame(
            $expected,
            $this->prepareSanitizer()->process($value, $options)
        );
    }

    /**
     * Bad min values provider
     *
     * @return array
     */
    public function badMinValuesProvider(): array
    {
        return [
            [
                10,
                10,
                [
                    'min' => 5,
                ],
            ],
            [
                10.0,
                10.0,
                [
                    'min' => 5,
                ],
            ],
            [
                '10.0',
                '10.0',
                [
                    'min' => 5,
                ],
            ],
        ];
    }

    /**
     * Test bad max values
     *
     * @param mixed $expected
     * @param mixed $value
     * @param array $options
     * @dataProvider badMaxValuesProvider
     */
    public function testBadMaxValues($expected, $value, array $options): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessageRegExp('#max \d+ characters#');

        $this->assertSame(
            $expected,
            $this->prepareSanitizer()->process($value, $options)
        );
    }

    /**
     * Bad max values provider
     *
     * @return array
     */
    public function badMaxValuesProvider(): array
    {
        return [
            [
                10,
                10,
                [
                    'max' => 1,
                ],
            ],
            [
                10.0,
                10.0,
                [
                    'max' => 1,
                ],
            ],
            [
                '10.0',
                '10.0',
                [
                    'max' => 1,
                ],
            ],
        ];
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
