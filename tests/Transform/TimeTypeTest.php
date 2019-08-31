<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\TimeType;

/**
 * Time type assert test
 */
class TimeTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return TimeType
     */
    protected function prepareAssert(): TimeType
    {
        return new TimeType();
    }

    /**
     * Test wrong values
     *
     * @dataProvider             providerTestGoodValues
     * @param mixed $value
     */
    public function testGoodValues($value): void
    {
        $assert = $this->prepareAssert();
        $this->assertSame(
            $value,
            $assert->process($value)
        );
    }

    /**
     * Wrong data provider
     *
     * @return array
     */
    public function providerTestGoodValues(): array
    {
        return [
            ['10:00:00.123456'],
            ['10:00:00'],
            ['10:00'],
        ];
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
     * Test object
     */
    public function testObject(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process([1]);
    }

    /**
     * Test allow
     */
    public function testAllow(): void
    {
        $this->assertSame(
            'now',
            $this->prepareAssert()->process(
                'now',
                [
                    'allow' => ['now'],
                ]
            )
        );
    }

    /**
     * Test bad format date
     */
    public function testBadFormatDate(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process('10-20-30');
    }

    /**
     * Test not existent date
     */
    public function testNotExistentDate(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process('10:60:30');
    }

    /**
     * Test bad min option
     */
    public function testBadMinOption(): void
    {
        $this->expectException(\Exception::class);

        $this->prepareAssert()->process(
            '10:20:30',
            [
                'min' => '10:60:30',
            ]
        );
    }

    /**
     * Test bad min option
     */
    public function testWrongMinOption(): void
    {
        $this->expectException(\Exception::class);

        $this->prepareAssert()->process(
            '10:20:30',
            [
                'min' => 'foo-bar',
            ]
        );
    }

    /**
     * Test min correct
     */
    public function testMinCorrect(): void
    {
        $this->assertSame(
            '10:20:30',
            $this->prepareAssert()->process(
                '10:20:30',
                [
                    'min' => '10:20:00',
                ]
            )
        );
    }

    /**
     * Test min less
     */
    public function testMinLess(): void
    {
        $this->expectException(\Apishka\Transformer\FriendlyException::class);
        $this->expectExceptionMessage('cannot be before 10:20:30');

        $this->prepareAssert()->process(
            '10:20:00',
            [
                'min' => '10:20:30',
            ]
        );
    }

    /**
     * Test bad max option
     */
    public function testBadMaxOption(): void
    {
        $this->expectException(\Exception::class);

        $this->prepareAssert()->process(
            '10:20:30',
            [
                'max' => '10:60:30',
            ]
        );
    }

    /**
     * Test bad min option
     */
    public function testWrongMaxOption(): void
    {
        $this->expectException(\Exception::class);

        $this->prepareAssert()->process(
            '10:20:30',
            [
                'max' => 'foo-bar',
            ]
        );
    }

    /**
     * Test max correct
     */
    public function testMaxCorrect(): void
    {
        $this->assertSame(
            '10:20:00',
            $this->prepareAssert()->process(
                '10:20:00',
                [
                    'max' => '10:20:30',
                ]
            )
        );
    }

    /**
     * Test max correct with microtime
     */
    public function testMaxCorrectWithMicrotime(): void
    {
        $this->assertSame(
            '10:20:00.0001',
            $this->prepareAssert()->process(
                '10:20:00.0001',
                [
                    'max' => '10:20:30.0001',
                ]
            )
        );
    }

    /**
     * Test min more
     */
    public function testMinMore(): void
    {
        $this->expectException(\Apishka\Transformer\FriendlyException::class);
        $this->expectExceptionMessage('cannot be before 10:20:00');

        $this->prepareAssert()->process(
            '10:20:30',
            [
                'max' => '10:20:00',
            ]
        );
    }
}
