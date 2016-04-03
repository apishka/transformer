<?php namespace Apishka\Validator;

/**
 * Transform abstract
 */

abstract class TransformAbstract implements TransformInterface
{
    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrors()
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

    protected function getDefaultError($name)
    {
        $errors = $this->getDefaultErrors();
        if (!array_key_exists($name, $errors))
            throw new \Exception('Message for ' . var_export($name, true) . ' not found in errors');

        return $errors[$name];
    }

    /**
     * Throw exception
     *
     * @param array  $options
     * @param string $name
     * @param array  $params
     */

    protected function throwException($options, $name, $params = array())
    {
        $error = (array_key_exists($name, $options))
            ? $options[$name]
            : $this->getDefaultError($name)
        ;

        throw FriendlyException::apishka($error, $params);
    }
}
