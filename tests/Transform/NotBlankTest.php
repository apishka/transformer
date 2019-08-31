<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\NotBlank;

/**
 * Not blank assert test
 */
class NotBlankTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return NotBlank
     */
    protected function prepareAssert(): NotBlank
    {
        return new NotBlank();
    }

    /**
     * Test integer
     */
    public function testInteger(): void
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(10)
        );
    }

    /**
     * Test string
     */
    public function testString(): void
    {
        $this->assertSame(
            '10',
            $this->prepareAssert()->process('10')
        );
    }

    /**
     * Test null
     */
    public function testNull(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('cannot be empty');

        $this->prepareAssert()->process(null);
    }

    /**
     * Test object
     */
    public function testObject(): void
    {
        $std_class = new \StdClass();

        $this->assertSame(
            $std_class,
            $this->prepareAssert()->process($std_class)
        );
    }

    /**
     * Test object
     */
    public function testArray(): void
    {
        $this->assertSame(
            [1],
            $this->prepareAssert()->process([1])
        );
    }

    /**
     * Test zero
     */
    public function testZero(): void
    {
        $this->assertSame(
            0,
            $this->prepareAssert()->process(0)
        );
    }

    /**
     * Test string with zero
     */
    public function testStringWithZero(): void
    {
        $this->assertSame(
            '0',
            $this->prepareAssert()->process('0')
        );
    }

    /**
     * Test float with zero
     */
    public function testFloatWithZero(): void
    {
        $this->assertSame(
            0.0,
            $this->prepareAssert()->process(0.0)
        );
    }

    /**
     * Test false
     */
    public function testFalse(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('cannot be empty');

        $this->prepareAssert()->process(false);
    }

    /**
     * Test empty string
     */
    public function testEmptyString(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('cannot be empty');

        $this->prepareAssert()->process('');
    }
}
