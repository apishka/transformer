<?php namespace Apishka\Validator;

/**
 * Sanitizer abstract
 */

abstract class SanitizerAbstract extends ConstraintAbstract
{
    /**
     * Is sanitizer
     *
     * @return bool
     */

    public function isSanitizer()
    {
        return true;
    }
}
