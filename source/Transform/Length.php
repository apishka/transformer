<?php

namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Not blank
 */
class Length extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */
    public function getSupportedNames()
    {
        return [
            'Transform/Length',
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

        if (!isset($options['min']) && !isset($options['max']))
            throw new \InvalidArgumentException('Not found "min" or "max" in options');

        $length = function_exists('mb_strlen')
            ? mb_strlen($value)
            : strlen($value)
        ;

        if (isset($options['min']) && $length < $options['min'])
            $this->throwException($options, 'error_min', ['count' => $options['min'], 'length' => $length]);

        if (isset($options['max']) && $length > $options['max'])
            $this->throwException($options, 'error_max', ['count' => $options['max'], 'length' => $length]);

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
            'error_min' => [
                'message'   => 'min {count} characters',
            ],
            'error_max' => [
                'message'   => 'max {count} characters',
            ],
        ];
    }
}
