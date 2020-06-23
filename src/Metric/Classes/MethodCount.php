<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Metric\Classes;

use Suffi\PHPMetric\Metric\MetricInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class MethodCount implements MetricInterface
{
    public function measure(TypeInterface $type): int
    {
        return $type->getMethods()->count();
    }
}
