<?php

namespace Apishka\Transformer\Transform\PostgreSQL;

use Apishka\Transformer\TransformAbstract;

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
        return [
            'Transform/PostgreSQL/Json',
        ];
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return string|null|\JsonSerializable|array
     */
    public function process($value, array $options = [])
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
        return [
            'error' => [
                'message'   => 'wrong input format',
            ],
        ];
    }
}
