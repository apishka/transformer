<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\FloatType;

/**
 * Float type assert test
 */

class FloatTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return FloatType
     */

    protected function prepareAssert()
    {
        return new FloatType();
    }

    /**
     * Test float
     */

    public function testFloat()
    {
        $this->assertSame(
            7.4,
            $this->prepareAssert()->process(7.4)
        );

        $this->assertSame(
            0.0,
            $this->prepareAssert()->process(0)
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
     * @expectedException        \Apishka\Transformer\Exception
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
            array('test'),
            array(function () {}),
            array(new \StdClass()),
        );
    }

    /**
     * Test with filters
     */

    public function testWithFilters()
    {
        $this->assertSame(
            1123123.123,
            $this->prepareAssert()->process('1 123 123.123')
        );
    }

    /**
     * Test without filters
     */

    public function testWithoutFilters()
    {
        $this->assertSame(
            1.0,
            $this->prepareAssert()->process(
                '1 123 123.123',
                array(
                    'apply_filters' => false,
                )
            )
        );
    }
}
