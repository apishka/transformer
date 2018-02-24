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
     * @return Phone
     */
    protected function prepareAssert()
    {
        return new Uri();
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
     * @expectedExceptionMessage wrong uri format
     */
    public function testObject()
    {
        $this->prepareAssert()->process(new \StdClass());
    }

    /**
     * Test array
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong uri format
     */
    public function testArray()
    {
        $this->prepareAssert()->process([1]);
    }

    /**
     * Test simple phone
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage wrong uri format
     */
    public function testBadUri()
    {
        $this->prepareAssert()->process('htt://example.com/');
    }

    /**
     * Test simple phone
     */
    public function testSimpleUri()
    {
        $this->assertSame(
            'http://example.com/',
            $this->prepareAssert()->process('http://example.com/')
        );
    }

    /**
     * Test simple phone
     */
    public function testSimpleUriWithQueryString()
    {
        $this->assertSame(
            'http://example.com/some/data?test&xx=aaa',
            $this->prepareAssert()->process('http://example.com/some/data?test&xx=aaa')
        );
    }
}
