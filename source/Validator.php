<?php namespace Apishka\Validator;

/**
 * Validator
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
     * @param array $validations
     *
     * @return mixed
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

            $value = Router::apishka()->getItem($validation)->process($value, $options);
        }

        return $value;
    }
}
