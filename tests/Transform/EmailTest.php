<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Email;

/**
 * Email assert test
 */
class EmailTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Email
     */
    protected function prepareAssert(): Email
    {
        return new Email();
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
        $this->expectExceptionMessage('wrong email format');

        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong email format');

        $this->prepareAssert()->process([1]);
    }

    /**
     * Test email
     */
    public function testSimpleEmail(): void
    {
        $this->assertSame(
            'test@example.com',
            $this->prepareAssert()->process(
                'test@example.com',
                [
                    'check_dns'     => false,
                ]
            )
        );
    }

    /**
     * Test local email
     */
    public function testLocalEmail(): void
    {
        $this->assertSame(
            'test@example',
            $this->prepareAssert()->process(
                'test@example',
                [
                    'check_dns'     => false,
                ]
            )
        );
    }

    /**
     * Test invalid email
     */
    public function testInvalidEmail(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong email format');

        $this->prepareAssert()->process(
            'test@',
            [
                'check_dns'     => false,
            ]
        );
    }
}
