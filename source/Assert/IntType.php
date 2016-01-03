<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;
use Apishka\Validator\Exception;

/**
 * Int type
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class IntType extends AssertAbstract
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
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return int|null
     */

    public function process($value, array $options = array())
    {
        if ($value === null)
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            throw new Exception($this->getErrorMessage($options, 'error'));

        if (strcmp($value, (int) $value) != 0)
            throw new Exception($this->getErrorMessage($options, 'error'));

        return (int) $value;
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrorMessages()
    {
        return array(
            'error' => 'is not integer',
        );
    }
}
