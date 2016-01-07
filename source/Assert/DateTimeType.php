<?php namespace Apishka\Validator\Assert;

/**
 * Date time type
 *
 * @uses DateTimeTypeAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
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
