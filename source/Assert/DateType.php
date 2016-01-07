<?php namespace Apishka\Validator\Assert;

/**
 * Date type
 *
 * @uses DateTimeTypeAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class DateType extends DateTimeTypeAbstract
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
     * Check date
     *
     * @param array $matches
     *
     * @return bool
     */

    protected function checkMatches($matches)
    {
        return $this->checkDate($matches['year'], $matches['month'], $matches['day']);
    }

    /**
     * Get pattern
     *
     * @return string
     */

    protected function getPattern()
    {
        return '#^' . static::PATTERN_DATE . '$#';
    }
}