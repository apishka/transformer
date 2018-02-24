<?php declare(strict_types = 1);

namespace Apishka\Transformer;

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
     * @return mixed
     */
    public function process($value, array $options = []);
}
