<?php namespace Apishka\Transformer\Transform;

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
            'Transform/DateTime',
        );
    }
}
