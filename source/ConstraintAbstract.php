<?php namespace Apishka\Validator;

/**
 * Constraint abstract
 *
 * @uses ConstraintInterface
 * @abstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

abstract class ConstraintAbstract implements ConstraintInterface
{
    /**
     * Is sanitizer
     *
     * @return bool
     */

    public function isSanitizer()
    {
        return false;
    }

    /**
     * Is assert
     *
     * @return bool
     */

    public function isAssert()
    {
        return false;
    }

    /**
     * Get error message
     *
     * @return string
     */

    protected function getErrorMessage($options, $name)
    {
        if (array_key_exists($name, $options))
            return $options[$name];

        return $this->getDefaultErrorMessage($name);
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrorMessages()
    {
        return array();
    }

    /**
     * Get default error message
     *
     * @param string $name
     *
     * @return string
     */

    protected function getDefaultErrorMessage($name)
    {
        $errors = $this->getDefaultErrorMessages();
        if (!array_key_exists($name, $errors))
            throw new \Exception('Message for ' . var_export($name, true) . ' not found in errors');

        return $errors[$name];
    }
}
