<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\DateType;

/**
 * Date type assert test
 */

class DateTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
     */

    protected function prepareAssert()
    {
        return new DateType();
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
     * @expectedExceptionMessage wrong input format
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Validator\Exception
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
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testBadFormatDate()
    {
        $this->prepareAssert()->process('10-03-1987');
    }

    /**
     * Test not existent date
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testNotExistentDate()
    {
        $this->prepareAssert()->process('2001-02-29');
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
            '2016-01-01',
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
            '2016-01-01',
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
            '2015-01-02',
            $this->prepareAssert()->process(
                '2015-01-02',
                array(
                    'min' => '2015-01-01',
                )
            )
        );
    }

    /**
     * Test min less
     *
     * @expectedException        \Apishka\Validator\FriendlyException
     * @expectedExceptionMessage cannot be before 2015-01-02
     */

    public function testMinLess()
    {
        $this->prepareAssert()->process(
            '2015-01-01',
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
            '2016-01-01',
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
            '2016-01-01',
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
            '2015-01-01',
            $this->prepareAssert()->process(
                '2015-01-01',
                array(
                    'max' => '2015-01-02',
                )
            )
        );
    }

    /**
     * Test min more
     *
     * @expectedException        \Apishka\Validator\FriendlyException
     * @expectedExceptionMessage cannot be before 2015-01-01
     */

    public function testMinMore()
    {
        $this->prepareAssert()->process(
            '2015-01-02',
            array(
                'max' => '2015-01-01',
            )
        );
    }
}
