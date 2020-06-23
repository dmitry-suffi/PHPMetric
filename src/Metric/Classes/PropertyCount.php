<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Metric\Classes;

use Suffi\PHPMetric\Metric\MetricInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class PropertyCount implements MetricInterface
{
    public function measure(TypeInterface $type): int
    {
        if ($type instanceof ClassInterface || $type instanceof TraitInterface) {
            return $type->getProperties()->count();
        }
        return 0;
    }
}
