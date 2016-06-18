<?php namespace Apishka\Validator\Transform;

use Apishka\Validator\TransformAbstract;

/**
 * Email type
 */

class Email extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/Email',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return string|null
     */

    public function process($value, array $options = array())
    {
        if ($value === null)
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

        $options = array_replace(
            array(
                'check_dns'     => true,
                'strict'        => true,
            ),
            $options
        );


        $validators     = array();

        if ($options['strict'])
            $validators[] = new \Egulias\EmailValidator\Validation\RFCValidation();

        if ($options['check_dns'])
            $validators[] = new \Egulias\EmailValidator\Validation\RFCValidation();

        $validations = new \Egulias\EmailValidator\Validation\MultipleValidationWithAnd($validators);

        $validator = new \Egulias\EmailValidator\EmailValidator();
        if (!$validator->isValid($value, $validations))
            $this->throwException($options, 'error');

        return (string) $value;
    }

    /**
     * Get default errors
     *
     * @return array
     */

    protected function getDefaultErrors()
    {
        return array(
            'error' => array(
                'message'   => 'wrong email format',
            ),
        );
    }
}
