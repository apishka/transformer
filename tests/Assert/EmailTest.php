<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\Email;

/**
 * Email assert test
 */

class EmailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
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
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage wrong email format
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Validator\Exception
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
     * @expectedException        \Apishka\Validator\Exception
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
