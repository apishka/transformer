<?php

namespace Apishka\Transformer\Transform;

/**
 * Time type
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
        return [
            'Transform/Time',
        ];
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
        if (!isset($matches['second']))
            $matches['second'] = 0;

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
