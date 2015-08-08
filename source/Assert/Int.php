<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;

/**
 * Int
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Int extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/Int',
            'Assert/Integer',
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

        if (strcmp($value, (int) $value) != 0)
            throw new Exception($options['message'] ?: 'is not integer');

        return (int) $value;
    }
}
