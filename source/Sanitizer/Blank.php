<?php namespace Apishka\Validator\Sanitizer;

use Apishka\Validator\SanitizerAbstract;

/**
 * Blank
 */

class Blank extends SanitizerAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Sanitizer/Blank',
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
