<?php

namespace ApishkaTest\Transformer\Transform;

use Apishka\Transformer\Transform;

/**
 * Callback assert test
 */
class CallbackTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Transform\Callback
     */
    protected function prepareAssert(): Transform\Callback
    {
        return new Transform\Callback();
    }

    /**
     * Test integer
     */
    public function testInteger(): void
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
    public function testIntegerArray(): void
    {
        $this->assertSame(
            10,
            $this->prepareAssert()->process(
                10,
                [
                    'callback' => [
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
                    ],
                ]
            )
        );
    }

    /**
     * Test no callback
     */
    public function testNoCallback(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Property "callback" not found in options');

        $this->prepareAssert()->process(10);
    }

    /**
     * Test bad callback
     */
    public function testBadCallback(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Callback is not function');

        $this->prepareAssert()->process(
            10,
            [
                'callback' => 10,
            ]
        );
    }

    /**
     * Test callback
     */
    public function testCallback(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('wrong value');

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
     */
    public function testCallbackArray(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('wrong value');

        $this->prepareAssert()->process(
            9,
            [
                'callback' => [
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
                ],
            ]
        );
    }

    /**
     * Test returning
     */
    public function testReturning(): void
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
    public function testReturningArray(): void
    {
        $this->assertSame(
            30,
            $this->prepareAssert()->process(
                10,
                [
                    'returning' => true,
                    'callback'  => [
                        function ($value)
                        {
                            return $value + 10;
                        },
                        function ($value)
                        {
                            return $value + 10;
                        },
                    ],
                ]
            )
        );
    }
}
