<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Metric\Classes;

use Suffi\PHPMetric\Metric\MetricInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class ConstantCount implements MetricInterface
{
    public function measure(TypeInterface $type): int
    {
        if ($type instanceof ClassInterface || $type instanceof InterfaceInterface) {
            return $type->getConstants()->count();
        }
        return 0;
    }
}