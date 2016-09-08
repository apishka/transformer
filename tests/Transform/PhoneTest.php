<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Phone;

/**
 * Phone assert test
 */

class PhoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Phone
     */

    protected function prepareAssert()
    {
        return new Phone();
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
     * @expectedExceptionMessage wrong phone format
     */

    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong phone format
     */

    public function testArray()
    {
        $this->prepareAssert()->process(array(1));
    }

    /**
     * Test empty country code
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage `country_code` must be defined in options
     */

    public function testEmptyCountryCode()
    {
        $this->prepareAssert()->process(
            '+79161234567'
        );
    }

    /**
     * Test simple phone
     */

    public function testSimplePhone()
    {
        $this->assertSame(
            '+79161234567',
            $this->prepareAssert()->process(
                '+79161234567',
                array(
                    'country_code' => 'RU',
                )
            )
        );
    }

    /**
     * Test simple phone
     */

    public function testSimplePhoneWithoutPlus()
    {
        $this->assertSame(
            '+79161234567',
            $this->prepareAssert()->process(
                '79161234567',
                array(
                    'country_code' => 'RU',
                )
            )
        );
    }

    /**
     * Test another phone format
     */

    public function testAnotherPhoneFormat()
    {
        $this->assertSame(
            '+7 916 123-45-67',
            $this->prepareAssert()->process(
                '79161234567',
                array(
                    'country_code' => 'RU',
                    'phone_format' => \libphonenumber\PhoneNumberFormat::INTERNATIONAL,
                )
            )
        );
    }

    /**
     * Test simple phone
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong phone format
     */

    public function testNotValidPhone()
    {
        $this->prepareAssert()->process(
            'some text',
            array(
                'country_code' => 'RU',
            )
        );
    }

    /**
     * Test toll free number
     */

    public function testTollFreeNumber()
    {
        $this->assertSame(
            '8003838',
            $this->prepareAssert()->process(
                '800(38-38)',
                array(
                    'country_code' => 'AE',
                )
            )
        );
    }

    /**
     * Test toll free number with letters
     */

    public function testTollFreeNumberWithLetters()
    {
        $this->assertSame(
            '8003838',
            $this->prepareAssert()->process(
                '800(du-du)',
                array(
                    'country_code' => 'AE',
                )
            )
        );
    }
}
