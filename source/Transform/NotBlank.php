<?php namespace Apishka\Validator\Transform;

use Apishka\Validator\TransformAbstract;

/**
 * Not blank
 */

class NotBlank extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/NotBlank',
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
        if (empty($value) && $value !== '0' && $value !== 0)
            $this->throwException($options, 'error');

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
                'message'   => 'cannot be empty',
            ),
        );
    }
}
