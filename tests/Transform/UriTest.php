<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Uri;

/**
 * Uri test
 */
class UriTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Uri
     */
    protected function prepareAssert(): Uri
    {
        return new Uri();
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
        $this->expectExceptionMessage('wrong uri format');

        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     */
    public function testArray(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong uri format');

        $this->prepareAssert()->process([1]);
    }

    /**
     * Test simple phone
     */
    public function testBadUri(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('wrong uri format');

        $this->prepareAssert()->process('htt://example.com/');
    }

    /**
     * Test simple phone
     */
    public function testSimpleUri(): void
    {
        $this->assertSame(
            'http://example.com/',
            $this->prepareAssert()->process('http://example.com/')
        );
    }

    /**
     * Test simple phone
     */
    public function testSimpleUriWithQueryString(): void
    {
        $this->assertSame(
            'http://example.com/some/data?test&xx=aaa',
            $this->prepareAssert()->process('http://example.com/some/data?test&xx=aaa')
        );
    }
}
