<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\StringType;

/**
 * String type assert test
 */

class StringTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return StringType
     */

    protected function prepareAssert()
    {
        return new StringType();
    }

    /**
     * Test string
     */

    public function testString()
    {
        $this->assertSame(
            'test',
            $this->prepareAssert()->process('test')
        );

        $this->assertSame(
            '1',
            $this->prepareAssert()->process(1)
        );

        $this->assertSame(
            '1.2',
            $this->prepareAssert()->process(1.2)
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
            array(array()),
            array(function () {}),
            array(new \StdClass()),
        );
    }
}
