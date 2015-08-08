<?php namespace Apishka\Validator;

/**
 * Validator
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Validator
{
    /**
     * Traits
     */

    use \Apishka\EasyExtend\Helper\ByClassNameTrait;

    /**
     * Validate
     *
     * @param mixed $value
     * @param mixed $validations
     *
     * @return value
     */

    public function validate($value, $validations)
    {
    }

    /**
     * Sanitize
     *
     * @param mixed $value
     * @param mixed $validations
     */

    public function sanitize($value, $validations)
    {
    }
}
