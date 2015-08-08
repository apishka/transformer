<?php namespace Apishka\Validator;

/**
 * Router
 *
 * @uses \Apishka\EasyExtend\Router\ByKeyAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Router extends \Apishka\EasyExtend\Router\ByKeyAbstract
{
    /**
     * Checks item for correct information
     *
     * @param \ReflectionClass $reflector
     *
     * @return bool
     */

    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        return $reflector->isSubclassOf('Apishka\Validator\ConstraintInterface');
    }

    /**
     * Get class variants
     *
     * @param \ReflectionClass $reflector
     * @param object           $item
     *
     * @return array
     */

    protected function getClassVariants(\ReflectionClass $reflector, $item)
    {
        return $item->getSupportedNames();
    }
}
