<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;

/**
 * String
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class String extends AssertAbstract
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
     * @return int
     */

    public function process($value, array $options = array())
    {
        if (is_object($value) || is_resource($value) || is_array($value))
            throw new Exception($options['message'] ?: 'is not integer');

        return (string) $value;
    }
}
