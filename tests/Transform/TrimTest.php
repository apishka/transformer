<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Trim;

/**
 * Trim sanitizer test
 */
class TrimTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Trim
     */
    protected function prepareSanitizer(): Trim
    {
        return new Trim();
    }

    /**
     * Test integer
     */
    public function testInteger(): void
    {
        $this->assertSame(
            '10',
            $this->prepareSanitizer()->process(10)
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
     * Test object
     */
    public function testObject(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareSanitizer()->process(new \StdClass());
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareSanitizer()->process([1]);
    }

    /**
     * Test right trim
     */
    public function testRightTrim(): void
    {
        $this->assertSame(
            'test',
            $this->prepareSanitizer()->process('test ')
        );
    }

    /**
     * Test left trim
     */
    public function testLeftTrim(): void
    {
        $this->assertSame(
            'test',
            $this->prepareSanitizer()->process(' test')
        );
    }

    /**
     * Test left trim
     */
    public function testTrim(): void
    {
        $this->assertSame(
            'test',
            $this->prepareSanitizer()->process(' test ')
        );
    }
}
