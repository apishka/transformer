<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\NotBlank;

/**
 * Not blank assert test
 */

class NotBlankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return NotBlank
     */

    protected function prepareAssert()
    {
        return new NotBlank();
    }

    /**
     * Test integer
     */

    public function testInteger()
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(10)
        );
    }

    /**
     * Test string
     */

    public function testString()
    {
        $this->assertSame(
            '10',
            $this->prepareAssert()->process('10')
        );
    }

    /**
     * Test null
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage cannot be empty
     */

    public function testNull()
    {
        $this->prepareAssert()->process(null);
    }

    /**
     * Test object
     */

    public function testObject()
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

    public function testArray()
    {
        $this->assertSame(
            array(1),
            $this->prepareAssert()->process(array(1))
        );
    }

    /**
     * Test zero
     */

    public function testZero()
    {
        $this->assertSame(
            0,
            $this->prepareAssert()->process(0)
        );
    }

    /**
     * Test string with zero
     */

    public function testStringWithZero()
    {
        $this->assertSame(
            '0',
            $this->prepareAssert()->process('0')
        );
    }

    /**
     * Test false
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage cannot be empty
     */

    public function testFalse()
    {
        $this->prepareAssert()->process(false);
    }

    /**
     * Test empty string
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage cannot be empty
     */

    public function testEmptyString()
    {
        $this->prepareAssert()->process('');
    }
}
