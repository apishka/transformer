<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Blank;

/**
 * Blank sanitizer test
 */
class BlankTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Blank
     */
    protected function prepareSanitizer(): Blank
    {
        return new Blank();
    }

    /**
     * Test integer
     */
    public function testInteger(): void
    {
        $this->assertSame(
            10,
            $this->prepareSanitizer()->process(10)
        );
    }

    /**
     * Test string
     */
    public function testString(): void
    {
        $this->assertSame(
            '10',
            $this->prepareSanitizer()->process('10')
        );
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
     * Test false
     */
    public function testFalse(): void
    {
        $this->assertNull(
            $this->prepareSanitizer()->process(false)
        );
    }

    /**
     * Test empty string
     */
    public function testEmptyString(): void
    {
        $this->assertNull(
            $this->prepareSanitizer()->process('')
        );
    }

    /**
     * Test string with 0
     */
    public function testStringWithZero(): void
    {
        $this->assertSame(
            '0',
            $this->prepareSanitizer()->process('0')
        );
    }

    /**
     * Test 0
     */
    public function testZero(): void
    {
        $this->assertSame(
            0,
            $this->prepareSanitizer()->process(0)
        );
    }

    /**
     * Test string
     */
    public function testFloatZero(): void
    {
        $this->assertSame(
            0.0,
            $this->prepareSanitizer()->process(0.0)
        );
    }
}
