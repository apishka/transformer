<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\NotBlank;

/**
 * Not blank assert test
 *
 * @uses \PHPUnit_Framework_TestCase
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class NotBlankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
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
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage is empty
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
        $stdClass = new \StdClass();

        $this->assertSame(
            $stdClass,
            $this->prepareAssert()->process($stdClass)
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
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage is empty
     */

    public function testFalse()
    {
        $this->prepareAssert()->process(false);
    }

    /**
     * Test empty string
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage is empty
     */

    public function testEmptyString()
    {
        $this->prepareAssert()->process('');
    }
}