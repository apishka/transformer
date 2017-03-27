<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Phone;

/**
 * Phone assert test
 */

class PhoneTest extends \PHPUnit\Framework\TestCase
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
     * @dataProvider             providerNotValidPhone
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong phone format
     */

    public function testNotValidPhone($phone, $country_code)
    {
        $this->prepareAssert()->process(
            $phone,
            array(
                'country_code' => $country_code,
            )
        );
    }

    /**
     * Provider not valid phone
     *
     * @return array
     */

    public function providerNotValidPhone()
    {
        return array(
            array('some text', 'RU'),
            array('00', 'AE'),
            array('anonymous', 'AE'),
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
     * Test uan number
     */

    public function testUanNumber()
    {
        $this->assertSame(
            '+917600544000',
            $this->prepareAssert()->process(
                '600(544-000)',
                array(
                    'country_code' => 'AE',
                )
            )
        );
    }

    /**
     * Test bad toll free number
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong phone format
     */

    public function testBadTollFreeNumber()
    {
        $this->prepareAssert()->process(
            '+800(38-38)',
            array(
                'country_code' => 'AE',
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

    /**
     * Test short phone
     */

    public function testShortPhone()
    {
        $this->assertSame(
            '+971501234567',
            $this->prepareAssert()->process(
                '0501234567',
                array(
                    'country_code' => 'AE',
                )
            )
        );
    }

    /**
     * Test bad phone
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong phone format
     */

    public function testBadPhone()
    {
        $this->prepareAssert()->process(
            '123456789012345789',
            array(
                'country_code' => 'AE',
            )
        );
    }

    /**
     * Test toll free number
     */

    public function testValidPhoneType()
    {
        $this->assertSame(
            '+971501115599',
            $this->prepareAssert()->process(
                '+971501115599',
                array(
                    'country_code' => 'AE',
                    'type_ids' => array(
                        \libphonenumber\PhoneNumberType::MOBILE,
                    ),
                )
            )
        );
    }

    /**
     * Test toll free number
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong phone type
     */

    public function testNotValidPhoneType()
    {
        $this->assertSame(
            '+971501115599',
            $this->prepareAssert()->process(
                '+971501115599',
                array(
                    'country_code' => 'AE',
                    'type_ids' => array(
                        \libphonenumber\PhoneNumberType::FIXED_LINE,
                    ),
                )
            )
        );
    }
}
