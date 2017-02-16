<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Number\Between;

/**
 * Length transform test
 */

class BetweenTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Lower
     */

    protected function prepareSanitizer()
    {
        return new Between();
    }

    /**
     * Test null
     */

    public function testNull()
    {
        $this->assertNull(
            $this->prepareSanitizer()->process(null)
        );
    }

    /**
     * Test no options
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Not found "min" or "max" in options
     */

    public function testNoOptiopns()
    {
        $this->prepareSanitizer()->process(10);
    }

    /**
     * Test good values
     *
     * @param mixed $expected
     * @param mixed $value
     * @param array $options
     *
     * @dataProvider             providerTestGoodValues
     */

    public function testGoodValues($expected, $value, array $options)
    {
        $this->assertSame(
            $expected,
            $this->prepareSanitizer()->process($value, $options)
        );
    }

    /**
     * Provider test good values
     *
     * @return array
     */

    public function providerTestGoodValues()
    {
        return array(
            array(
                2,
                2,
                array(
                    'min' => 0,
                    'max' => 5,
                ),
            ),
            array(
                2.0,
                2.0,
                array(
                    'min' => 0,
                    'max' => 5,
                ),
            ),
            array(
                '2.0',
                '2.0',
                array(
                    'min' => 0,
                    'max' => 5,
                ),
            ),
        );
    }

    /**
     * Test bad min values
     *
     * @param mixed $expected
     * @param mixed $value
     * @param array $options
     *
     * @expectedException              \Apishka\Transformer\Exception
     * @expectedExceptionMessageRegExp #min \d+#
     * @dataProvider                   providerTestBadMinValues
     */

    public function testBadMinValues($value, array $options)
    {
        $this->prepareSanitizer()->process($value, $options);
    }

    /**
     * Bad min values provider
     *
     * @return array
     */

    public function providerTestBadMinValues()
    {
        return array(
            array(
                2,
                array(
                    'min' => 5,
                ),
            ),
            array(
                3.0,
                array(
                    'min' => 5,
                ),
            ),
            array(
                '4.0',
                array(
                    'min' => 5,
                ),
            ),
        );
    }

    /**
     * Test bad max values
     *
     * @param mixed $value
     * @param array $options
     *
     * @expectedException              \Apishka\Transformer\Exception
     * @expectedExceptionMessageRegExp #max \d+#
     * @dataProvider                   providerTestBadMaxValues
     */

    public function testBadMaxValues($value, array $options)
    {
        $this->prepareSanitizer()->process($value, $options);
    }

    /**
     * Bad max values provider
     *
     * @return array
     */

    public function providerTestBadMaxValues()
    {
        return array(
            array(
                10,
                array(
                    'max' => 3,
                ),
            ),
            array(
                10.0,
                array(
                    'max' => 3,
                ),
            ),
            array(
                '10.0',
                array(
                    'max' => 3,
                ),
            ),
        );
    }

    /**
     * Test wrong values
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong input format
     * @dataProvider             providerTestWrongValues
     */

    public function testWrongValues($wrong_type)
    {
        $assert = $this->prepareSanitizer();
        $assert->process($wrong_type);
    }

    /**
     * Wrong data provider
     *
     * @return array
     */

    public function providerTestWrongValues()
    {
        return array(
            array(array()),
            array(STDOUT),
            array(function () {}),
            array(new \StdClass()),
        );
    }
}
