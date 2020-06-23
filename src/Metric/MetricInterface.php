<?php

namespace Suffi\PHPMetric\Metric;

use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Интерфейс метрики
 * Interface MetricInterface
 */
interface MetricInterface
{
    /**
     * @param TypeInterface $type
     * @return int|float|bool
     */
    public function measure(TypeInterface $type);
}