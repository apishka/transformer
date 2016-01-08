<?php namespace Apishka\Validator\Sanitizer;

use Apishka\Validator\SanitizerAbstract;

/**
 * Lower
 *
 * @uses SanitizerAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Lower extends SanitizerAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Sanitizer/Lower',
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
        return array(
            'error' => array(
                'message'   => 'wrong input format',
            ),
        );
    }
}
