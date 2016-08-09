<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\DateTimeType;

/**
 * Date time type assert test
 */

class DateTimeTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
     */

    protected function prepareAssert()
    {
        return new DateTimeType();
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
        $this->prepareAssert()->process('10-03-1987 10:20:30');
    }

    /**
     * Test not existent date
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testNotExistentDate()
    {
        $this->prepareAssert()->process('2001-02-29 10:20:30');
    }

    /**
     * Test bad min option
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Variable for "min" is not date
     */

    public function testBadMinOption()
    {
        $this->prepareAssert()->process(
            '2016-01-01 10:20:30',
            array(
                'min' => '2001-02-29',
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
            '2016-01-01 10:20:30',
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
            '2015-01-02 10:20:30',
            $this->prepareAssert()->process(
                '2015-01-02 10:20:30',
                array(
                    'min' => '2015-01-01',
                )
            )
        );
    }

    /**
     * Test min less
     *
     * @expectedException        \Apishka\Transformer\FriendlyException
     * @expectedExceptionMessage cannot be before 2015-01-02
     */

    public function testMinLess()
    {
        $this->prepareAssert()->process(
            '2015-01-01 10:20:30',
            array(
                'min' => '2015-01-02',
            )
        );
    }

    /**
     * Test bad max option
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Variable for "max" is not date
     */

    public function testBadMaxOption()
    {
        $this->prepareAssert()->process(
            '2016-01-01 10:20:30',
            array(
                'max' => '2001-02-29',
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
            '2016-01-01 10:20:30',
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
            '2015-01-01 10:20:30',
            $this->prepareAssert()->process(
                '2015-01-01 10:20:30',
                array(
                    'max' => '2015-01-02',
                )
            )
        );
    }

    /**
     * Test min more
     *
     * @expectedException        \Apishka\Transformer\FriendlyException
     * @expectedExceptionMessage cannot be before 2015-01-01
     */

    public function testMinMore()
    {
        $this->prepareAssert()->process(
            '2015-01-02 10:20:30',
            array(
                'max' => '2015-01-01',
            )
        );
    }
}
