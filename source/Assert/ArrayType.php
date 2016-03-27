<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;

/**
 * Array type
 */

class ArrayType extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/Array',
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

        if (!is_array($value))
            $this->throwException($options, 'error');

        return $value;
    }

    /**
     * Get default errors
     *
     * @return array
     */

    protected function getDefaultErrors()
    {
        return array(
            'error' => array(
                'message'   => 'wrong input format',
            ),
        );
    }
}
