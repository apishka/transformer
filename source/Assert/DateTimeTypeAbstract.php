<?php namespace Apishka\Validator\Assert;

use Apishka\Validator\AssertAbstract;
use Carbon\Carbon;

/**
 * Date time type abstract
 *
 * @uses AssertAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

abstract class DateTimeTypeAbstract extends AssertAbstract
{
    /**
     * Patterns
     */

    const PATTERN_DATE = '(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})';
    const PATTERN_TIME = '(?P<hour>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})(?:\.(?P<microsecond>\d+))?';

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
            $this->getDefaultOptons(),
            $options
        );

        if ($value === null)
            return;

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
                $min = new Carbon($options['min']);
                if ($min === false || $min->getLastErrors()['warning_count'])
                    throw new \InvalidArgumentException('Variable for "min" is not date');

                if ($date->diffInSeconds($min, false) > 0)
                    $this->throwException($options, 'error_max', array('date' => $options['min']));
            }

            if ($options['max'])
            {
                $max = new Carbon($options['max']);
                if ($max === false || $max->getLastErrors()['warning_count'])
                    throw new \InvalidArgumentException('Variable for "max" is not date');

                if ($date->diffInSeconds($max, false) < 0)
                    $this->throwException($options, 'error_max', array('date' => $options['max']));
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
        return array(
            'allow' => [],
            'min'   => false,
            'max'   => false,
        );
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
                'message'   => 'cannot be after {date}',
            ),
            'error_max' => array(
                'message'   => 'cannot be before {date}',
            ),
        );
    }
}
