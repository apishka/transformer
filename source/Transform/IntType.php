<?php namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Int type
 */

class IntType extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/Int',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return int|null
     */

    public function process($value, array $options = array())
    {
        if ($value === null)
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

        $value = $this->applyFilters($value, $options);

        if (strcmp($value, (int) $value) != 0)
            $this->throwException($options, 'error');

        return (int) $value;
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
