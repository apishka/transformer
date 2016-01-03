<?php namespace ApishkaTest\Validator\Sanitizer;

use Apishka\Validator\Sanitizer\Blank;

/**
 * Blank sanitizer test
 *
 * @uses \PHPUnit_Framework_TestCase
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class BlankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
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
        $this->assertNull(
            $this->prepareSanitizer()->process('0')
        );
    }

    /**
     * Test 0
     */

    public function testZero()
    {
        $this->assertNull(
            $this->prepareSanitizer()->process(0)
        );
    }
}
