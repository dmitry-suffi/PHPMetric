<?php

namespace Suffi\PHPMetric\Metric;

use Suffi\PHPMetric\Model\TypesCollection;

/**
 * Интерфейс измерителя
 * Interface MeasurerInterface
 */
interface MeasurerInterface
{
    public function measureTypes(TypesCollection $typesCollection): MeasuredCollection;

    public function measure(MeasuredCollection $measuredCollection): MeasuredCollection;
}
