<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\NotNull;

/**
 * Not null assert test
 */
class NotNullTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return NotNull
     */
    protected function prepareAssert(): NotNull
    {
        return new NotNull();
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
     * Test string
     */
    public function testString(): void
    {
        $this->assertSame(
            '10',
            $this->prepareAssert()->process('10')
        );
    }

    /**
     * Test null
     */
    public function testNull(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('cannot be empty');

        $this->prepareAssert()->process(null);
    }
}
