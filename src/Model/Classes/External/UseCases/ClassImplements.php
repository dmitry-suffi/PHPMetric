<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\External\UseCases;

use Suffi\PHPMetric\Model\Classes\External\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Class ClassExtend
 *
 * @property InterfaceInterface $type
 */
class ClassImplements extends UseCase
{
    protected ClassInterface $sourceType;

    public function __construct(InterfaceInterface $type, ClassInterface $sourceType)
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
