<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\NotNull;

/**
 * Not null assert test
 *
 * @uses \PHPUnit_Framework_TestCase
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class NotNullTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
     */

    protected function prepareAssert()
    {
        return new NotNull();
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
     * @expectedExceptionMessage is null
     */

    public function testNull()
    {
        $this->prepareAssert()->process(null);
    }
}
