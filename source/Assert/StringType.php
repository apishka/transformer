<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;

/**
 * String type
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class StringType extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/String',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return string|null
     */

    public function process($value, array $options = array())
    {
        if ($value === null)
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            throw new Exception($this->getErrorMessage($options, 'error'));

        return (string) $value;
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrorMessages()
    {
        return array(
            'error' => 'is not string',
        );
    }
}
