<?php namespace Apishka\Validator;

/**
 * Assert abstract
 *
 * @uses ConstraintAbstract
 * @abstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

abstract class AssertAbstract extends ConstraintAbstract
{
    /**
     * Is assert
     *
     * @return bool
     */

    public function isAssert()
    {
        return true;
    }
}
