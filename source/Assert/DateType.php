<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;

/**
 * Date type
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class DateType extends AssertAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/Date',
        );
    }

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return float|null
     */

    public function process($value, array $options = array())
    {
        $options = array_replace(
            array(
                'allow' => [],
                'min'   => false,
                'max'   => false,
            ),
            $options
        );

        if ($value === null)
            return;

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

        // Can be used to allow 'now' or 'today' for example
        if ($options['allow'] && in_array($value, $options['allow']))
            return $value;

        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $matches))
            $this->throwException($options, 'error');

        if (!checkdate($matches[1], $matches[2], $matches[3]))
            $this->throwException($options, 'error');

        if ($options['min'] || $options['max'])
        {
            $date = date_parse($value);

            if ($options['min'])
            {
                $min = date_create($options['min']);
                if ($min === false)
                    throw new \InvalidArgumentException('Variable for "min" is not date');

                if (intval($date->diff($min)->format('%r%a')) > 0)
                    $this->throwException($options, 'error_max', array('min' => $options['min']));
            }

            if ($options['max'])
            {
                $max = date_create($options['max']);
                if ($max === false)
                    throw new \InvalidArgumentException('Variable for "max" is not date');

                if (intval($value_date->diff($max)->format('%r%a')) < 0)
                    $this->throwException($options, 'error_max', array('max' => $options['max']));
            }
        }

        return $value;
    }

    /**
     * Get default error messages
     *
     * @return array
     */

    protected function getDefaultErrors()
    {
        return array(
            'error' => array(
                'message'   => 'wrong input format',
            ),
            'error_min' => array(
                'message'   => 'cannot be before {date}',
            ),
            'error_max' => array(
                'message'   => 'cannot be after {date}',
            ),
        );
    }
}
