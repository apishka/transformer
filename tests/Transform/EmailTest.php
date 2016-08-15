<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Email;

/**
 * Email assert test
 */

class EmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Email
     */

    protected function prepareAssert()
    {
        return new Email();
    }

    /**
     * Test null
     */

    public function testNull()
    {
        $this->assertNull(
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test object
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong email format
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong email format
     */

    public function testArray()
    {
        $this->prepareAssert()->process(array(1));
    }

    /**
     * Test email
     */

    public function testSimpleEmail()
    {
        $this->assertSame(
            'test@example.com',
            $this->prepareAssert()->process(
                'test@example.com',
                array(
                    'check_dns'     => false,
                )
            )
        );
    }

    /**
     * Test local email
     */

    public function testLocalEmail()
    {
        $this->assertSame(
            'test@example',
            $this->prepareAssert()->process(
                'test@example',
                array(
                    'check_dns'     => false,
                )
            )
        );
    }

    /**
     * Test invalid email
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong email format
     */

    public function testInvalidEmail()
    {
        $this->prepareAssert()->process(
            'test@',
            array(
                'check_dns'     => false,
            )
        );
    }
}
