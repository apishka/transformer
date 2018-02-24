<?php

namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Callback
 */
class Callback extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */
    public function getSupportedNames()
    {
        return [
            'Transform/Callback',
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
        $result_value = $value;

        if (!array_key_exists('callback', $options))
            throw new \InvalidArgumentException('Property "callback" not found in options');

        $callbacks = !is_array($options['callback'])
            ? [$options['callback']]
            : $options['callback']
        ;

        foreach ($callbacks as $callback)
        {
            if (!($callback instanceof \Closure))
                throw new \InvalidArgumentException('Callback is not function');

            $result = $callback($result_value);
            if (array_key_exists('returning', $options) && $options['returning'])
                $result_value = $result;
        }

        return $result_value;
    }
}
