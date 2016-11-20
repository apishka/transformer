<?php namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

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

        $value = $this->applyFilters($value, $options);

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

    /**
     * Apply filters
     *
     * @param mixed $value
     * @param array $options
     *
     * @return mixed
     */

    protected function applyFilters($value, $options = array())
    {
        if (array_key_exists('apply_filters', $options) && !$options['apply_filters'])
            return $value;

        $filters = array(
            '#\s+#',
        );

        return preg_replace($filters, '', $value);
    }
}
