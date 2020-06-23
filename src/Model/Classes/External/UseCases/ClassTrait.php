<?php

namespace Suffi\PHPMetric\Model\Classes\External\UseCases;

use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\External\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Class ClassTrait
 * @property TraitInterface $type
 */
class ClassTrait extends UseCase
{
    protected ClassType $sourceType;

    public function __construct(TraitInterface $type, ClassType $sourceType)
    {
        $this->sourceType = $sourceType;
        parent::__construct($type);
    }

    public function define(TypeInterface $type)
    {
        if (!$type instanceof TraitInterface) {
            throw new Exception("Invalid param");
        }

        $this->sourceType->getTraits()->replace($type->getFullName(), $type);
        $this->isDefined = true;
    }
}
