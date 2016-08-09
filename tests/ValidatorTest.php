<?php namespace ApishkaTest\Transformer;

use Apishka\Transformer\Validator;

/**
 * Validator test
 */

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return int
     */

    protected function prepareValidator()
    {
        return new Validator();
    }

    /**
     * Test not null
     */

    public function testNotNull()
    {
        $this->prepareValidator()->validate(
            10,
            [
                'Transform/NotNull' => [],
            ]
        );
    }

    /**
     * Test null
     *
     * @expectedException        \Apishka\Transformer\Exception
     * @expectedExceptionMessage cannot be empty
     */

    public function testNull()
    {
        $this->prepareValidator()->validate(
            null,
            [
                'Transform/NotNull' => [],
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

    public function testCallbackWithBooleanCondition()
    {
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
        );
    }

    /**
     * Test callback with function condition
     */

    public function testCallbackWithFunctionCondition()
    {
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
        );
    }
}
