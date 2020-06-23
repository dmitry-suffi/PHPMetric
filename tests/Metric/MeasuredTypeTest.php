<?php

declare(strict_types=1);

namespace Tests\Metric;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\MeasuredType;
use Suffi\PHPMetric\Metric\MetricValue;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class MeasuredTypeTest extends TestCase
{
    public function testAddValue(): void
    {
        $type = $this->getMockBuilder(TypeInterface::class)->getMock();

        $measuredType = new MeasuredType($type);

        $measuredType->addValue(new MetricValue('metricA', 4));

        /**  @var MetricValue $metricValue */
        $metricValue = $measuredType->getValue('metricA');
        $this->assertInstanceOf(MetricValue::class, $metricValue);
        $this->assertEquals(4, $metricValue->getValue());
    }

    public function testNotExistValue(): void
    {
        $type = $this->getMockBuilder(TypeInterface::class)->getMock();

        $measuredType = new MeasuredType($type);

        $this->expectException(\Exception::class);
        $measuredType->getValue('metricA');
    }
}
