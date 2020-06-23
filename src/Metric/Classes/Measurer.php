<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Metric\Classes;

use Suffi\PHPMetric\Metric\MeasuredCollection;
use Suffi\PHPMetric\Metric\MeasuredType;
use Suffi\PHPMetric\Metric\MeasurerInterface;
use Suffi\PHPMetric\Metric\MetricValue;
use Suffi\PHPMetric\Model\TypesCollection;

class Measurer extends \Suffi\PHPMetric\Metric\Measurer
{
    public function measure(MeasuredCollection $measuredCollection): MeasuredCollection
    {
        $metrics = [
            'ConstantCount' => new ConstantCount() ,
            'MethodCount' => new MethodCount(),
            'PropertyCount' => new PropertyCount()
        ];

        foreach ($measuredCollection->getAll() as $measuredType) {
            foreach ($metrics as $name => $metric) {
                $measuredType->addValue(new MetricValue($name, $metric->measure($measuredType->getType())));
            }
        }

        return $measuredCollection;
    }
}
