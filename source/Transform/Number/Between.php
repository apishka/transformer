<?php namespace Apishka\Transformer\Transform\Number;

use Apishka\Transformer\TransformAbstract;

/**
 * Not blank
 */

class Between extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/Number/Between',
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

        if (!isset($options['min']) && !isset($options['max']))
            throw new \InvalidArgumentException('Not found "min" or "max" in options');

        if (isset($options['min']) && $value < $options['min'])
            $this->throwException($options, 'error_min', ['count' => $options['min']]);

        if (isset($options['max']) && $value > $options['max'])
            $this->throwException($options, 'error_max', ['count' => $options['max']]);

        return $value;
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
            'error_min' => array(
                'message'   => 'min {count}',
            ),
            'error_max' => array(
                'message'   => 'max {count}',
            ),
        );
    }
}
