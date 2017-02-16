<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Upper;

/**
 * Upper transform test
 */

class UpperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Lower
     */

    protected function prepareSanitizer()
    {
        return new Upper();
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
     * Test string
     */

    public function testString()
    {
        $this->assertSame(
            '10',
            $this->prepareSanitizer()->process(10)
        );

        $this->assertSame(
            'TEST',
            $this->prepareSanitizer()->process('tEsT')
        );

        $this->assertSame(
            '',
            $this->prepareSanitizer()->process('')
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
        $assert = $this->prepareSanitizer();
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
            array(STDOUT),
            array(function () {}),
            array(new \StdClass()),
        );
    }
}
