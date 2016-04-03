<?php namespace ApishkaTest\Validator\Transform;

use Apishka\Validator\Transform\BoolType;

/**
 * Bool type assert test
 */

class BoolTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return BoolType
     */

    protected function prepareAssert()
    {
        return new BoolType();
    }

    /**
     * Test valid data
     */

    public function testValid()
    {
        $this->assertSame(
            1,
            $this->prepareAssert()->process('test')
        );

        $this->assertSame(
            1,
            $this->prepareAssert()->process(2)
        );

        $this->assertSame(
            0,
            $this->prepareAssert()->process(0)
        );

        $this->assertSame(
            0,
            $this->prepareAssert()->process(false)
        );

        $this->assertSame(
            0,
            $this->prepareAssert()->process('0')
        );
    }

    /**
     * Test null
     */

    public function testNull()
    {
        $this->assertSame(
            null,
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test wrong values
     *
     * @dataProvider             wrongValuesProvider
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage wrong input format
     */

    public function testWrongValues($wrong_type)
    {
        $assert = $this->prepareAssert();
        $assert->process($wrong_type);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */

    public function wrongValuesProvider()
    {
        return array(
            array(STDOUT),
            array(function () {}),
            array(new \StdClass()),
        );
    }
}
