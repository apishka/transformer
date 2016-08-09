<?php namespace Apishka\Transformer;

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
            $condition = true;
            if (is_array($options) && array_key_exists('condition', $options))
            {
                $condition = $options['condition'];
                if ($condition instanceof \Closure)
                    $condition = call_user_func($condition);
            }

            if ($condition)
                $value = Router::apishka()->getItem($validation)->process($value, $options);
        }

        return $value;
    }
}
