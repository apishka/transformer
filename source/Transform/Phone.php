<?php namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;

/**
 * Phone type
 */

class Phone extends TransformAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Transform/Phone',
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

        if (!class_exists('\libphonenumber\PhoneNumberUtil'))
            throw new \RuntimeException('Library for phone checking not found');

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

        try
        {
            $util = \libphonenumber\PhoneNumberUtil::getInstance();

            $is_toll_free = true;
            $phone = $util->parse($value, $this->getDefaultCountryCode($options));
            if ($util->getNumberType($phone) != \libphonenumber\phonenumberType::TOLL_FREE)
            {
                $is_toll_free = false;
                if (!preg_match('#^\+#', $value))
                    $value = '+' . $value;

                $phone = $util->parse($value, $this->getDefaultCountryCode($options));
            }
        }
        catch(\libphonenumber\NumberParseException $e)
        {
            $this->throwException($options, 'error');
        }

        if (!$util->isValidNumber($phone))
            $this->throwException($options, 'error');

        if ($is_toll_free)
            return $phone->getNationalNumber();

        return (string) $util->format($phone, $this->getDefaultPhoneFormat($options));
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
                'message'   => 'wrong phone format',
            ),
        );
    }

    /**
     * Get default country code
     *
     * @param array $options
     *
     * @return string
     */

    protected function getDefaultCountryCode($options)
    {
        if (!isset($options['country_code']))
            throw new \InvalidArgumentException('`country_code` must be defined in options');

        return $options['country_code'];
    }

    /**
     * Get default phone format
     *
     * @param array $options
     *
     * @return string
     */

    protected function getDefaultPhoneFormat($options)
    {
        if (!isset($options['phone_format']))
            return \libphonenumber\PhoneNumberFormat::E164;

        return $options['phone_format'];
    }
}
