<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Parser;

use Suffi\PHPMetric\Model\Classes\External\ExternalInterfaceType;
use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\External\UseCases\ClassImplements;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class ClassExpandUseCaseHandler implements UseCaseHandlerInterface
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
     * @param ClassInterface     $currentType
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
     * @param ClassInterface     $currentType
     * @param InterfaceInterface $object
     */
    public function createUseCase(TypeInterface $currentType, TypeInterface $object): UseCaseInterface
    {
        return new ClassImplements($object, $currentType);
    }
}
