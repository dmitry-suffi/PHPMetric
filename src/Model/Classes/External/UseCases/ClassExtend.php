<?php

namespace Suffi\PHPMetric\Model\Classes\External\UseCases;

use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\External\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Class ClassExtend
 * @property ClassInterface $type
 */
class ClassExtend extends UseCase
{
    protected ClassType $sourceType;

    public function __construct(ClassInterface $type, ClassType $sourceType)
    {
        $this->sourceType = $sourceType;
        parent::__construct($type);
    }

    public function define(TypeInterface $type)
    {
        if (!$type instanceof ClassInterface) {
            throw new Exception("Invalid param");
        }

        $this->sourceType->setParent($type);
        $this->isDefined = true;
    }
}