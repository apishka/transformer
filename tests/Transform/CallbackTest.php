<?php namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform\Callback;

/**
 * Callback assert test
 */

class CallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Callback
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
     * Test integer array
     */

    public function testIntegerArray()
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(
                10,
                [
                    'callback' => array(
                        function ($value)
                        {
                            if ($value !== 10)
                                throw new \Exception();
                        },
                        function ($value)
                        {
                            if (!is_int(10))
                                throw new \Exception();
                        },
                    ),
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
     * @expectedExceptionMessage Callback is not function
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

    /**
     * Test callback array
     *
     * @expectedException        \Exception
     * @expectedExceptionMessage wrong value
     */

    public function testCallbackArray()
    {
        $this->prepareAssert()->process(
            9,
            [
                'callback' => array(
                    function ($value)
                    {
                        if ($value !== 10)
                            throw new \Exception('wrong value');
                    },
                    function ($value)
                    {
                        if ($value !== 11)
                            throw new \Exception('wrong value in two');
                    },
                ),
            ]
        );
    }

    /**
     * Test returning
     */

    public function testReturning()
    {
        $this->assertSame(
            20,
            $this->prepareAssert()->process(
                10,
                [
                    'returning' => true,
                    'callback'  => function ($value)
                    {
                        return $value + 10;
                    },
                ]
            )
        );
    }

    /**
     * Test returning array
     */

    public function testReturningArray()
    {
        $this->assertSame(
            30,
            $this->prepareAssert()->process(
                10,
                [
                    'returning' => true,
                    'callback'  => array(
                        function ($value)
                        {
                            return $value + 10;
                        },
                        function ($value)
                        {
                            return $value + 10;
                        },
                    ),
                ]
            )
        );
    }
}
