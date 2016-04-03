<?php namespace Apishka\Validator\Transform;

use Apishka\Validator\TransformAbstract;

/**
 * Float type
 */

class FloatType extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/Float',
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
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

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
            $this->throwException($options, 'error');

        return (float) $value;
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
