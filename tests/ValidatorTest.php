<?php namespace ApishkaTest\Validator;

use Apishka\Validator\Validator;

/**
 * Validator test
 *
 * @uses \PHPUnit_Framework_TestCase
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare assert
     *
     * @return Int
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
                'Assert/NotNull',
            ]
        );
    }

    /**
     * Test null
     *
     * @expectedException        \Apishka\Validator\Exception
     * @expectedExceptionMessage cannot be empty
     */

    public function testNull()
    {
        $this->prepareValidator()->validate(
            null,
            [
                'Assert/NotNull',
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
                'Assert/Callback' => [
                    'callback' => function ($value)
                    {
                        if ($value === 'test')
                            throw new \Exception('wrong value');
                    },
                ],
            ]
        );
    }
}
