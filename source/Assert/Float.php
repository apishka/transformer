<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;
use Apishka\Validator\Exception;

/**
 * Float
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Float extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/Float',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return float|null
     */

    public function process($value, array $options = array())
    {
        if ($value === null)
            return null;

        if (is_object($value) || is_resource($value) || is_array($value))
            throw new Exception($this->getErrorMessage($options, 'error'));

        $patterns = array(
            '#^[+-]?[0-9]+$#',
            '#^[+-]?([0-9]*[\.][0-9]+)|([0-9]+[\.][0-9]*)$#',
            '#^[+-]?(([0-9]+|([0-9]*[\.][0-9]+)|([0-9]+[\.][0-9]*))[eE][+-]?[0-9]+)$#',
        );

        $is_float = false;
        foreach ($patterns as $pattern)
        {
            if (preg_match($pattern, $value))
            {
                $is_float = true;
                break;
            }
        }

        if (!$is_float)
            throw new Exception($this->getErrorMessage($options, 'error'));

        return (float) $value;
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrorMessages()
    {
        return array(
            'error' => 'is not float',
        );
    }
}
