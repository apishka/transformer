<?php

namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Array type
 */
class ArrayType extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */
    public function getSupportedNames()
    {
        return [
            'Transform/Array',
        ];
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return string|null
     */
    public function process($value, array $options = [])
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
        return [
            'error' => [
                'message'   => 'wrong input format',
            ],
        ];
    }
}
