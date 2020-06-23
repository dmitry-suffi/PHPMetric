<?php

namespace Suffi\PHPMetric\Parser;

use Suffi\PHPMetric\Model\Classes\External\ExternalClassType;
use Suffi\PHPMetric\Model\Classes\External\ExternalInterfaceType;
use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\External\UseCases\InterfaceExtend;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class InterfaceExtendUseCaseHandler implements UseCaseHandlerInterface
{
    public function checkType($object): bool
    {
        if (!$object instanceof InterfaceInterface) {
            //@todo logic exceptions
            return false;
        }
        return true;
    }

    /**
     * @param InterfaceInterface $currentType
     * @param InterfaceInterface $object
     */
    public function add(TypeInterface $currentType, TypeInterface $object): void
    {
        $currentType->getExpands()->add($object);
    }

    public function createType(string $name, string $fullName): ExternalInterfaceType
    {
        return new ExternalInterfaceType($name, $fullName);
    }

    /**
     * @param InterfaceInterface $currentType
     * @param InterfaceInterface $object
     */
    public function createUseCase(TypeInterface $currentType, TypeInterface $object): UseCaseInterface
    {
        return new InterfaceExtend($object, $currentType);
    }
}
