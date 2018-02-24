<?php

namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Lower
 */
class Lower extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */
    public function getSupportedNames()
    {
        return [
            'Transform/Lower',
        ];
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return mixed
     */
    public function process($value, array $options = [])
    {
        if ($value === null)
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

        if (function_exists('mb_strtolower'))
            return mb_strtolower($value);

        return strtolower($value);
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
