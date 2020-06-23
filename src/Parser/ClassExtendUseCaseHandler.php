<?php

namespace Suffi\PHPMetric\Parser;

use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\External\ExternalClassType;
use Suffi\PHPMetric\Model\Classes\External\ExternalInterfaceType;
use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\External\UseCases\ClassExtend;
use Suffi\PHPMetric\Model\Classes\External\UseCases\ClassImplements;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class ClassExtendUseCaseHandler implements UseCaseHandlerInterface
{
    public function checkType($object): bool
    {
        if (!$object instanceof ClassInterface) {
            //@todo logic exceptions
            return false;
        }
        return true;
    }

    /**
     * @param ClassType $currentType
     * @param ClassInterface $object
     */
    public function add(TypeInterface $currentType, TypeInterface $object): void
    {
        $currentType->setParent($object);
    }

    public function createType(string $name, string $fullName): ExternalClassType
    {
        return new ExternalClassType($name, $fullName);
    }

    /**
     * @param ClassInterface $currentType
     * @param ClassInterface $object
     */
    public function createUseCase(TypeInterface $currentType, TypeInterface $object): ClassExtend
    {
        return new ClassExtend($object, $currentType);
    }
}