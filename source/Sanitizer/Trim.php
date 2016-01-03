<?php namespace Apishka\Validator\Sanitizer;

use Apishka\Validator\Exception;
use Apishka\Validator\SanitizerAbstract;

/**
 * Trim
 *
 * @uses SanitizerAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Trim extends SanitizerAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Sanitizer/Trim',
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
            throw new Exception($this->getErrorMessage($options, 'error'));

        return trim($value);
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrorMessages()
    {
        return array(
            'error' => 'is not string',
        );
    }
}
