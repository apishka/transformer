<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\NotNull;

/**
 * Not null assert test
 */

class NotNullTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return NotNull
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
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage cannot be empty
     */

    public function testNull()
    {
        $this->prepareAssert()->process(null);
    }
}
