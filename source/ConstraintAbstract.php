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
}
