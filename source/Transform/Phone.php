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
            $phone = $this->getPhone($value, $options, $type_id);
        }
        catch(\libphonenumber\NumberParseException $e)
        {
            $this->throwException($options, 'error');
        }

        $util = \libphonenumber\PhoneNumberUtil::getInstance();

        if (!$util->isValidNumber($phone))
            $this->throwException($options, 'error');

        if (array_key_exists('type_ids', $options) && !in_array($type_id, $options['type_ids']))
            $this->throwException($options, 'wrong_type');

        if ($type_id == \libphonenumber\phonenumberType::TOLL_FREE)
            return $phone->getNationalNumber();

        return (string) $util->format($phone, $this->getDefaultPhoneFormat($options));
    }

    /**
     * Get phone
     *
     * @param string $value
     * @param array  $options
     * @param int    $type_id
     *
     * @return \libphonenumber\PhoneNumber
     */

    protected function getPhone($value, $options, &$type_id)
    {
        $util = \libphonenumber\PhoneNumberUtil::getInstance();

        $phone = $util->parse($value, $this->getDefaultCountryCode($options));

        $type_id = $util->getNumberType($phone);

        if ($type_id == \libphonenumber\phonenumberType::TOLL_FREE || $type_id == \libphonenumber\phonenumberType::UAN)
            return $phone;

        $values = array_unique(
            array(
                !preg_match('#^\+#', $value) ? '+' . $value : $value,
                $value,
            )
        );

        foreach ($values as $value)
        {
            try
            {
                 return $util->parse($value, $this->getDefaultCountryCode($options));
            }
            catch (\libphonenumber\NumberParseException $e)
            {
            }
        }

        throw $e;
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
            'wrong_type' => array(
                'message'   => 'wrong phone type',
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
