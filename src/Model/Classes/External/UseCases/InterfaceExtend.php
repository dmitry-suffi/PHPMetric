<?php

namespace Suffi\PHPMetric\Model\Classes\External\UseCases;

use Suffi\PHPMetric\Model\Classes\External\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Class InterfaceExtend
 * @property InterfaceInterface $type
 */
class InterfaceExtend extends UseCase
{
    protected InterfaceInterface $sourceType;

    public function __construct(InterfaceInterface $type, InterfaceInterface $sourceType)
    {
        $this->sourceType = $sourceType;
        parent::__construct($type);
    }

    public function define(TypeInterface $type)
    {
        if (!$type instanceof InterfaceInterface) {
            throw new Exception("Invalid param");
        }

        $this->sourceType->getExpands()->replace($type->getFullName(), $type);
        $this->isDefined = true;
    }
}