<?php namespace Apishka\Validator;

/**
 * Assert abstract
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
