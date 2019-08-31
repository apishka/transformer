<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\IntType;

/**
 * Integer assert test
 */
class IntTypeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return IntType
     */
    protected function prepareAssert(): IntType
    {
        return new IntType();
    }

    /**
     * Test integer
     */
    public function testInteger(): void
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(10)
        );
    }

    /**
     * Test float
     */
    public function testFloat(): void
    {
        $this->assertSame(
            0,
            $this->prepareAssert()->process(0.0)
        );
    }

    /**
     * Test string
     */
    public function testString(): void
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process('10')
        );
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
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process([1]);
    }

    /**
     * Test negative string
     */
    public function testNegativeString(): void
    {
        $this->assertSame(
            -10,
            $this->prepareAssert()->process('-10')
        );
    }

    /**
     * Test bad string
     */
    public function testBadString(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process('123abc');
    }

    /**
     * Test filters
     */
    public function testFilters(): void
    {
        $this->assertSame(
            1123123,
            $this->prepareAssert()->process('1 123 123')
        );
    }

    /**
     * Test without filters
     */
    public function testWithoutFilters(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong input format');

        $this->prepareAssert()->process(
            '1 123 123',
            [
                'apply_filters' => false,
            ]
        );
    }
}
