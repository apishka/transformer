<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;
use Apishka\Validator\Exception;

/**
 * Callback
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Callback extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/NotNull',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return mixed
     */

    public function process($value, array $options = array())
    {
        if (!array_key_exists('callback', $options))
            throw new Exception($this->getErrorMessage($options, 'error_no_callback'));

        if (!($options['callback'] instanceof \Closure))
            throw new Exception($this->getErrorMessage($options, 'error_bad_callback'));

        $options['callback']($value);

        return $value;
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrorMessages()
    {
        return array(
            'error'              => 'is not valid',
            'error_no_callback'  => 'callback not found',
            'error_bad_callback' => 'bad callback',
        );
    }
}
