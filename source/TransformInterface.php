<?php namespace Apishka\Transformer;

/**
 * Transform interface
 */

interface TransformInterface
{
    /**
     * Get supported names
     *
     * @return array
     */

    public function getSupportedNames();

    /**
     * Process
     *
     * @param mixed $value
     * @param array $options
     *
     * @return int
     */

    public function process($value, array $options = array());
}
