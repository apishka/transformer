<?php namespace Apishka\Validator\Assert;

/**
 * Date time type
 */

class DateTimeType extends DateTimeTypeAbstract
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames()
    {
        return array(
            'Assert/DateTime',
        );
    }
}
