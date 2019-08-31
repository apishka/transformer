<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Number\Between;

/**
 * Length transform test
 */
class BetweenTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Between
     */
    protected function prepareSanitizer(): Between
    {
        return new Between();
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
                2,
                2,
                [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
            [
                2.0,
                2.0,
                [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
            [
                '2.0',
                '2.0',
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
     * @param mixed $value
     * @param array $options
     *
     * @dataProvider                   providerTestBadMinValues
     */
    public function testBadMinValues($value, array $options): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessageRegExp('#min \d+#');

        $this->prepareSanitizer()->process($value, $options);
    }

    /**
     * Bad min values provider
     *
     * @return array
     */
    public function providerTestBadMinValues(): array
    {
        return [
            [
                2,
                [
                    'min' => 5,
                ],
            ],
            [
                3.0,
                [
                    'min' => 5,
                ],
            ],
            [
                '4.0',
                [
                    'min' => 5,
                ],
            ],
        ];
    }

    /**
     * Test bad max values
     *
     * @param mixed $value
     * @param array $options
     *
     * @dataProvider                   providerTestBadMaxValues
     */
    public function testBadMaxValues($value, array $options): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessageRegExp('#max \d+#');

        $this->prepareSanitizer()->process($value, $options);
    }

    /**
     * Bad max values provider
     *
     * @return array
     */
    public function providerTestBadMaxValues(): array
    {
        return [
            [
                10,
                [
                    'max' => 3,
                ],
            ],
            [
                10.0,
                [
                    'max' => 3,
                ],
            ],
            [
                '10.0',
                [
                    'max' => 3,
                ],
            ],
        ];
    }

    /**
     * Test wrong values
     *
     * @dataProvider             providerTestWrongValues
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
    public function providerTestWrongValues(): array
    {
        return [
            [[]],
            [STDOUT],
            [function () {}],
            [new \StdClass()],
        ];
    }
}
