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
        foreach ($validations as $validation => $options)
        {
            if (is_int($validation))
            {
                $validation = $options;
                $options    = array();
            }

            Router::apishka()->getItem($validation)->process($value, $options);
        }
    }
}
