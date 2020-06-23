<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Metric;

use Suffi\PHPMetric\Model\TypesCollection;

abstract class Measurer implements MeasurerInterface
{
    public function measureTypes(TypesCollection $typesCollection): MeasuredCollection
    {
        $measuredCollection = new MeasuredCollection();

        foreach ($typesCollection->getTypes() as $type) {
            $measuredType = new MeasuredType($type);
            $measuredCollection->addMeasuredType($measuredType);
        }

        return $this->measure($measuredCollection);
    }

    abstract public function measure(MeasuredCollection $measuredCollection): MeasuredCollection;
}
