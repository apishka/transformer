<?php namespace Apishka\Validator\Assert;

/**
 * Time type
 *
 * @uses DateTimeTypeAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class TimeType extends DateTimeTypeAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/Time',
        );
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
        if (!isset($matches['microsecond']))
            $matches['microsecond'] = 0;

        return $this->checkTime($matches['hour'], $matches['minute'], $matches['second'], $matches['microsecond']);
    }

    /**
     * Get pattern
     *
     * @return string
     */

    protected function getPattern()
    {
        return '#^' . static::PATTERN_TIME . '$#';
    }
}
