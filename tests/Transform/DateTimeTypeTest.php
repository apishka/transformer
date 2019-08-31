<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\DateTimeType;

/**
 * Date time type assert test
 */
class DateTimeTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return DateTimeType
     */
    protected function prepareAssert(): DateTimeType
    {
        return new DateTimeType();
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

        $this->prepareAssert()->process('10-03-1987 10:20:30');
    }

    /**
     * Test not existent date
     */
    public function testNotExistentDate(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process('2001-02-29 10:20:30');
    }

    /**
     * Test bad min option
     */
    public function testBadMinOption(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Variable for "min" is not date');

        $this->prepareAssert()->process(
            '2016-01-01 10:20:30',
            [
                'min' => '2001-02-29',
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
            '2016-01-01 10:20:30',
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
            '2015-01-02 10:20:30',
            $this->prepareAssert()->process(
                '2015-01-02 10:20:30',
                [
                    'min' => '2015-01-01',
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
        $this->expectExceptionMessage('cannot be before 2015-01-02');

        $this->prepareAssert()->process(
            '2015-01-01 10:20:30',
            [
                'min' => '2015-01-02',
            ]
        );
    }

    /**
     * Test bad max option
     */
    public function testBadMaxOption(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Variable for "max" is not date');

        $this->prepareAssert()->process(
            '2016-01-01 10:20:30',
            [
                'max' => '2001-02-29',
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
            '2016-01-01 10:20:30',
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
            '2015-01-01 10:20:30',
            $this->prepareAssert()->process(
                '2015-01-01 10:20:30',
                [
                    'max' => '2015-01-02',
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
        $this->expectExceptionMessage('cannot be before 2015-01-01');

        $this->prepareAssert()->process(
            '2015-01-02 10:20:30',
            [
                'max' => '2015-01-01',
            ]
        );
    }
}
