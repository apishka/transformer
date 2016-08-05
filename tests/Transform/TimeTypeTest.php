<?php namespace Apishka\Transformer\Transform;

use Apishka\Transformer\Transform\TimeType;

/**
 * Time type assert test
 */

class TimeTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
     */

    protected function prepareAssert()
    {
        return new TimeType();
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
     * @expectedExceptionMessage wrong input format
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testArray()
    {
        $this->prepareAssert()->process(array(1));
    }

    /**
     * Test allow
     */

    public function testAllow()
    {
        $this->assertSame(
            'now',
            $this->prepareAssert()->process(
                'now',
                array(
                    'allow' => array('now'),
                )
            )
        );
    }

    /**
     * Test bad format date
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testBadFormatDate()
    {
        $this->prepareAssert()->process('10-20-30');
    }

    /**
     * Test not existent date
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testNotExistentDate()
    {
        $this->prepareAssert()->process('10:60:30');
    }

    /**
     * Test bad min option
     *
     * @expectedException        \Exception
     */

    public function testBadMinOption()
    {
        $this->prepareAssert()->process(
            '10:20:30',
            array(
                'min' => '10:60:30',
            )
        );
    }

    /**
     * Test bad min option
     *
     * @expectedException        \Exception
     */

    public function testWrongMinOption()
    {
        $this->prepareAssert()->process(
            '10:20:30',
            array(
                'min' => 'foo-bar',
            )
        );
    }

    /**
     * Test min correct
     */

    public function testMinCorrect()
    {
        $this->assertSame(
            '10:20:30',
            $this->prepareAssert()->process(
                '10:20:30',
                array(
                    'min' => '10:20:00',
                )
            )
        );
    }

    /**
     * Test min less
     *
     * @expectedException        \Apishka\Transformer\FriendlyException
     * @expectedExceptionMessage cannot be before 10:20:30
     */

    public function testMinLess()
    {
        $this->prepareAssert()->process(
            '10:20:00',
            array(
                'min' => '10:20:30',
            )
        );
    }

    /**
     * Test bad max option
     *
     * @expectedException        \Exception
     */

    public function testBadMaxOption()
    {
        $this->prepareAssert()->process(
            '10:20:30',
            array(
                'max' => '10:60:30',
            )
        );
    }

    /**
     * Test bad min option
     *
     * @expectedException        \Exception
     */

    public function testWrongMaxOption()
    {
        $this->prepareAssert()->process(
            '10:20:30',
            array(
                'max' => 'foo-bar',
            )
        );
    }

    /**
     * Test max correct
     */

    public function testMaxCorrect()
    {
        $this->assertSame(
            '10:20:00',
            $this->prepareAssert()->process(
                '10:20:00',
                array(
                    'max' => '10:20:30',
                )
            )
        );
    }

    /**
     * Test max correct with microtime
     */

    public function testMaxCorrectWithMicrotime()
    {
        $this->assertSame(
            '10:20:00.0001',
            $this->prepareAssert()->process(
                '10:20:00.0001',
                array(
                    'max' => '10:20:30.0001',
                )
            )
        );
    }

    /**
     * Test min more
     *
     * @expectedException        \Apishka\Transformer\FriendlyException
     * @expectedExceptionMessage cannot be before 10:20:00
     */

    public function testMinMore()
    {
        $this->prepareAssert()->process(
            '10:20:30',
            array(
                'max' => '10:20:00',
            )
        );
    }
}
