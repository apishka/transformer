<?php namespace Apishka\Validator\Assert\PostgreSQL;

use Apishka\Validator\AssertAbstract;

/**
 * Json type
 */

class Json extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/PostgreSQL/Json',
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

        $result = json_decode($value, true);

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
