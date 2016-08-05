<?php namespace Apishka\Transformer\Transform;

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
        return array(
            'Transform/Callback',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return mixed
     */

    public function process($value, array $options = array())
    {
        if (!array_key_exists('callback', $options))
            throw new \InvalidArgumentException('Property "callback" not found in options');

        if (!($options['callback'] instanceof \Closure))
            throw new \InvalidArgumentException('Property "callback" is not function');

        $options['callback']($value);

        return $value;
    }
}
