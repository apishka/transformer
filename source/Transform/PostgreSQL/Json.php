<?php namespace Apishka\Validator\Transform\PostgreSQL;

use Apishka\Validator\TransformAbstract;

/**
 * Json type
 */

class Json extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/PostgreSQL/Json',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return string|null|\JsonSerializable|array
     */

    public function process($value, array $options = array())
    {
        if ($value === null)
            return;

        if (is_resource($value))
            $this->throwException($options, 'error');

        if (is_array($value))
            return $value;

        if ($value instanceof \JsonSerializable)
            return $value;

        if (is_object($value))
            $this->throwException($options, 'error');

        if (!is_string($value))
            $this->throwException($options, 'error');

        $result = json_decode($value, true);

        if (json_last_error() != JSON_ERROR_NONE)
            $this->throwException($options, 'error');

        if (!is_array($result))
            $this->throwException($options, 'error');

        return $result;
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
