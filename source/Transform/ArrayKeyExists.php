<?php

namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Array key exists
 */
class ArrayKeyExists extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */
    public function getSupportedNames()
    {
        return [
            'Transform/ArrayKeyExists',
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

        if (!array_key_exists('values', $options))
            throw new \InvalidArgumentException('Property "values" not found in options');

        if (!is_array($options['values']) && !($options['values'] instanceof \Closure))
            throw new \InvalidArgumentException('Property "values" is not function');

        $values = is_array($options['values'])
            ? $options['values']
            : call_user_func($options['values'])
        ;

        if (!array_key_exists((string) $value, $values))
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
