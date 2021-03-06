<?php

namespace Apishka\Transformer\Transform;

use Apishka\Transformer\TransformAbstract;
use Carbon\Carbon;

/**
 * Date time type abstract
 */
abstract class DateTimeTypeAbstract extends TransformAbstract
{
    /**
     * Patterns
     */
    const PATTERN_DATE = '(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})';
    const PATTERN_TIME = '(?P<hour>\d{2}):(?P<minute>\d{2})(?::(?P<second>\d{2})(?:\.(?P<microsecond>\d+))?)?';

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return float|null
     */
    public function process($value, array $options = [])
    {
        $options = array_replace(
            $this->getDefaultOptons(),
            $options
        );

        if ($value === null)
            return null;

        if (is_object($value) || is_resource($value) || is_array($value))
            $this->throwException($options, 'error');

        // Can be used to allow 'now' or 'today' for example
        if ($options['allow'] && in_array($value, $options['allow']))
            return $value;

        if (!preg_match($this->getPattern(), $value, $matches))
            $this->throwException($options, 'error');

        if (!$this->checkMatches($matches))
            $this->throwException($options, 'error');

        if ($options['min'] || $options['max'])
        {
            $date = new Carbon($value);

            if ($options['min'])
            {
                try
                {
                    $min = new Carbon($options['min']);
                }
                catch (\InvalidArgumentException $e)
                {
                    $min = false;
                }

                if ($min === false || $min->getLastErrors()['warning_count'])
                    throw new \InvalidArgumentException('Variable for "min" is not date');

                if ($date->diffInSeconds($min, false) > 0)
                    $this->throwException($options, 'error_max', ['date' => $options['min']]);
            }

            if ($options['max'])
            {
                try
                {
                    $max = new Carbon($options['max']);
                }
                catch (\InvalidArgumentException $e)
                {
                    $max = false;
                }

                if ($max === false || $max->getLastErrors()['warning_count'])
                    throw new \InvalidArgumentException('Variable for "max" is not date');

                if ($date->diffInSeconds($max, false) < 0)
                    $this->throwException($options, 'error_max', ['date' => $options['max']]);
            }
        }

        return $value;
    }

    /**
     * Check date
     *
     * @param array $matches
     *
     * @return bool
     */
    protected function checkMatches($matches)
    {
        if (!$this->checkDate($matches['year'], $matches['month'], $matches['day']))
            return false;

        if (!isset($matches['microsecond']))
            $matches['microsecond'] = 0;

        if (!isset($matches['second']))
            $matches['microsecond'] = 0;

        if (!$this->checkTime($matches['hour'], $matches['minute'], $matches['second']))
            return false;

        return true;
    }

    /**
     * Check date
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return bool
     */
    protected function checkDate($year, $month, $day)
    {
        return checkdate($month, $day, $year);
    }

    /**
     * Check time
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return bool
     */
    protected function checkTime($hour, $minute, $second)
    {
        return $hour >= 0 && $hour < 24 && $minute >= 0 && $minute < 60 && $second >= 0 && $second < 60;
    }

    /**
     * Get pattern
     *
     * @return string
     */
    protected function getPattern()
    {
        return '#^' . static::PATTERN_DATE . ' ' . static::PATTERN_TIME . '$#';
    }

    /**
     * Get default optons
     *
     * @return array
     */
    protected function getDefaultOptons()
    {
        return [
            'allow' => [],
            'min'   => false,
            'max'   => false,
        ];
    }

    /**
     * Get default error messages
     *
     * @return array
     */
    protected function getDefaultErrors()
    {
        return [
            'error' => [
                'message'   => 'wrong input format',
            ],
            'error_min' => [
                'message'   => 'cannot be after {date}',
            ],
            'error_max' => [
                'message'   => 'cannot be before {date}',
            ],
        ];
    }
}
