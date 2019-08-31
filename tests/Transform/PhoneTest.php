<?php

namespace ApishkaTest\Transformer\Transform;

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
    protected function prepareAssert(): Phone
    {
        return new Phone();
    }

    /**
     * Test null
     */
    public function testNull(): void
    {
        $this->assertNull(
            $this->prepareAssert()->process(null)
        );
    }

    /**
     * Test object
     */
    public function testObject(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong phone format');

        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong phone format');

        $this->prepareAssert()->process([1]);
    }

    /**
     * Test empty country code
     */
    public function testEmptyCountryCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('`country_code` must be defined in options');

        $this->prepareAssert()->process(
            '+79161234567'
        );
    }

    /**
     * Test simple phone
     */
    public function testSimplePhone(): void
    {
        $this->assertSame(
            '+79161234567',
            $this->prepareAssert()->process(
                '+79161234567',
                [
                    'country_code' => 'RU',
                ]
            )
        );
    }

    /**
     * Test simple phone
     */
    public function testSimplePhoneWithoutPlus(): void
    {
        $this->assertSame(
            '+79161234567',
            $this->prepareAssert()->process(
                '79161234567',
                [
                    'country_code' => 'RU',
                ]
            )
        );
    }

    /**
     * Test another phone format
     */
    public function testAnotherPhoneFormat(): void
    {
        $this->assertSame(
            '+7 916 123-45-67',
            $this->prepareAssert()->process(
                '79161234567',
                [
                    'country_code' => 'RU',
                    'phone_format' => \libphonenumber\PhoneNumberFormat::INTERNATIONAL,
                ]
            )
        );
    }

    /**
     * Test simple phone
     *
     * @dataProvider             providerNotValidPhone
     * @param mixed $phone
     * @param mixed $country_code
     */
    public function testNotValidPhone($phone, $country_code): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong phone format');

        $this->prepareAssert()->process(
            $phone,
            [
                'country_code' => $country_code,
            ]
        );
    }

    /**
     * Provider not valid phone
     *
     * @return array
     */
    public function providerNotValidPhone(): array
    {
        return [
            ['some text', 'RU'],
            ['00', 'AE'],
            ['anonymous', 'AE'],
        ];
    }

    /**
     * Test toll free number
     */
    public function testTollFreeNumber(): void
    {
        $this->assertSame(
            '8003838',
            $this->prepareAssert()->process(
                '800(38-38)',
                [
                    'country_code' => 'AE',
                ]
            )
        );
    }

    /**
     * Test uan number
     */
    public function testUanNumber(): void
    {
        $this->assertSame(
            '+971600544000',
            $this->prepareAssert()->process(
                '600(544-000)',
                [
                    'country_code' => 'AE',
                ]
            )
        );
    }

    /**
     * Test bad toll free number
     */
    public function testBadTollFreeNumber(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong phone format');

        $this->prepareAssert()->process(
            '+800(38-38)',
            [
                'country_code' => 'AE',
            ]
        );
    }

    /**
     * Test toll free number with letters
     */
    public function testTollFreeNumberWithLetters(): void
    {
        $this->assertSame(
            '8003838',
            $this->prepareAssert()->process(
                '800(du-du)',
                [
                    'country_code' => 'AE',
                ]
            )
        );
    }

    /**
     * Test short phone
     */
    public function testShortPhone(): void
    {
        $this->assertSame(
            '+971501234567',
            $this->prepareAssert()->process(
                '0501234567',
                [
                    'country_code' => 'AE',
                ]
            )
        );
    }

    /**
     * Test bad phone
     */
    public function testBadPhone(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong phone format');

        $this->prepareAssert()->process(
            '123456789012345789',
            [
                'country_code' => 'AE',
            ]
        );
    }

    /**
     * Test toll free number
     */
    public function testValidPhoneType(): void
    {
        $this->assertSame(
            '+971501115599',
            $this->prepareAssert()->process(
                '+971501115599',
                [
                    'country_code' => 'AE',
                    'type_ids' => [
                        \libphonenumber\PhoneNumberType::MOBILE,
                    ],
                ]
            )
        );
    }

    /**
     * Test toll free number
     */
    public function testNotValidPhoneType(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong phone type');

        $this->assertSame(
            '+971501115599',
            $this->prepareAssert()->process(
                '+971501115599',
                [
                    'country_code' => 'AE',
                    'type_ids' => [
                        \libphonenumber\PhoneNumberType::FIXED_LINE,
                    ],
                ]
            )
        );
    }
}
