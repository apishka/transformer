<?php

namespace ApishkaTest\Transformer;

use Apishka\Transformer\Validator;

/**
 * Validator test
 */
class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Prepare assert
     *
     * @return Validator
     */
    protected function prepareValidator(): Validator
    {
        return new Validator();
    }

    /**
     * Test not null
     */
    public function testNotNull(): void
    {
        $this->assertSame(
            10,
            $this->prepareValidator()->validate(
                10,
                [
                    'Transform/NotNull' => [],
                ]
            )
        );
    }

    /**
     * Test null
     */
    public function testNull(): void
    {
        $this->expectException(\Apishka\Transformer\Exception::class);
        $this->expectExceptionMessage('cannot be empty');

        $this->prepareValidator()->validate(
            null,
            [
                'Transform/NotNull' => [],
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

        $this->prepareValidator()->validate(
            'test',
            [
                'Transform/Callback' => [
                    'callback' => function ($value)
                    {
                        if ($value === 'test')
                            throw new \Exception('wrong value');
                    },
                ],
            ]
        );
    }

    /**
     * Test callback with boolean condition
     */
    public function testCallbackWithBooleanCondition(): void
    {
        $this->assertSame(
            'test',
            $this->prepareValidator()->validate(
                'test',
                [
                    'Transform/Callback' => [
                        'callback' => function ($value)
                        {
                            throw new \Exception('wrong value');
                        },
                        'condition' => false,
                    ],
                ]
            )
        );
    }

    /**
     * Test callback with function condition
     */
    public function testCallbackWithFunctionCondition(): void
    {
        $this->assertSame(
            'test',
            $this->prepareValidator()->validate(
                'test',
                [
                    'Transform/Callback' => [
                        'callback' => function ($value)
                        {
                            throw new \Exception('wrong value');
                        },
                        'condition' => function ()
                        {
                            return false;
                        },
                    ],
                ]
            )
        );
    }
}
