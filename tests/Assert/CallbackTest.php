<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\Callback;

/**
 * Callback assert test
 *
 * @uses \PHPUnit_Framework_TestCase
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class CallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
     */

    protected function prepareAssert()
    {
        return new Callback();
    }

    /**
     * Test integer
     */

    public function testInteger()
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(
                10,
                [
                    'callback' => function ($value)
                    {
                        if ($value !== 10)
                            throw new \Exception();
                    },
                ]
            )
        );
    }

    /**
     * Test no callback
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage callback not found
     */

    public function testNoCallback()
    {
        $this->prepareAssert()->process(10);
    }

    /**
     * Test bad callback
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage bad callback
     */

    public function testBadCallback()
    {
        $this->prepareAssert()->process(
            10,
            [
                'callback' => 10,
            ]
        );
    }

    /**
     * Test callback
     *
     * @expectedException        \Exception
     * @expectedExceptionMessage wrong value
     */

    public function testCallback()
    {
        $this->prepareAssert()->process(
            9,
            [
                'callback' => function ($value)
                {
                    if ($value !== 10)
                        throw new \Exception('wrong value');
                },
            ]
        );
    }
}
