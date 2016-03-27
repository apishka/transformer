<?php namespace Apishka\Validator;

/**
 * Constraint interface
 */

interface ConstraintInterface
{
    /**
     * Is sanitizer
     *
     * @return bool
     */

    public function isSanitizer();

    /**
     * Is assert
     *
     * @return bool
     */

    public function isAssert();

    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames();

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return int
     */

    public function process($value, array $options = array());
}
