<?php namespace ApishkaTest\Validator\Assert;

use Apishka\Validator\Assert\Callback;

/**
 * Callback assert test
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
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Property "callback" not found in options
     */

    public function testNoCallback()
    {
        $this->prepareAssert()->process(10);
    }

    /**
     * Test bad callback
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Property "callback" is not function
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
