<?php namespace Apishka\Validator;

/**
 * Sanitizer abstract
 *
 * @uses ConstraintAbstract
 * @abstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
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
