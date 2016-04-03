<?php namespace Apishka\Validator\Transform;

use Apishka\Validator\TransformAbstract;

/**
 * Blank
 */

class Blank extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/Blank',
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
        if (empty($value) && $value !== '0' && $value !== 0)
            return;

        return $value;
    }
}
