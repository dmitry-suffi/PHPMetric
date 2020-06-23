<?php


namespace Suffi\PHPMetric\Parser;


use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\External\ExternalTraitType;
use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\External\UseCases\ClassTrait;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class TraitUseCaseHandler implements UseCaseHandlerInterface
{
    public function checkType($object): bool
    {
        if (!$object instanceof TraitInterface) {
            //@todo logic exceptions
            return false;
        }
        return true;
    }

    /**
     * @param ClassInterface $currentType
     * @param TraitInterface $object
     */
    public function add(TypeInterface $currentType, TypeInterface $object): void
    {
        $currentType->getTraits()->add($object);
    }

    public function createType(string $name, string $fullName): TraitInterface
    {
        return new ExternalTraitType($name, $fullName);
    }

    /**
     * @param ClassType $currentType
     * @param TraitInterface $object
     */
    public function createUseCase(TypeInterface $currentType, TypeInterface $object): ClassTrait
    {
        return new ClassTrait($object, $currentType);
    }
}