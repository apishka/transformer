<?php declare(strict_types = 1);

namespace Apishka\Transformer;

use Apishka\EasyExtend\Router\ByKeyAbstract;

/**
 * Router
 */
class Router extends ByKeyAbstract
{
    /**
     * Checks item for correct information
     *
     * @param \ReflectionClass $reflector
     *
     * @return bool
     */
    protected function isCorrectItem(\ReflectionClass $reflector): bool
    {
        return $reflector->isSubclassOf(TransformInterface::class);
    }

    /**
     * Get class variants
     *
     * @param \ReflectionClass $reflector
     * @param object           $item
     *
     * @return array
     */
    protected function getClassVariants(\ReflectionClass $reflector, $item): array
    {
        return $item->getSupportedNames();
    }
}
