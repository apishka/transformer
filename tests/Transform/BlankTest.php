<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Blank;

/**
 * Blank sanitizer test
 */

class BlankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Blank
     */

    protected function prepareSanitizer()
    {
        return new Blank();
    }

    /**
     * Test integer
     */

    public function testInteger()
    {
        $this->assertSame(
            10,
            $this->prepareSanitizer()->process(10)
        );
    }

    /**
     * Test string
     */

    public function testString()
    {
        $this->assertSame(
            '10',
            $this->prepareSanitizer()->process('10')
        );
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
     * Test false
     */

    public function testFalse()
    {
        $this->assertNull(
            $this->prepareSanitizer()->process(false)
        );
    }

    /**
     * Test empty string
     */

    public function testEmptyString()
    {
        $this->assertNull(
            $this->prepareSanitizer()->process('')
        );
    }

    /**
     * Test string with 0
     */

    public function testStringWithZero()
    {
        $this->assertEquals(
            '0',
            $this->prepareSanitizer()->process('0')
        );
    }

    /**
     * Test 0
     */

    public function testZero()
    {
        $this->assertEquals(
            0,
            $this->prepareSanitizer()->process(0)
        );
    }
}
