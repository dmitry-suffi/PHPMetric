<?php

namespace Tests\Metric\Extend;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Extend\Measurer;
use Suffi\PHPMetric\Metric\MetricValue;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\TraitType;
use Suffi\PHPMetric\Model\TypesCollection;

class MeasurerTraitNOCTest extends TestCase
{
    public function testMeasureTraitNOC0(): void
    {
        $types = new TypesCollection();

        $traitA = new TraitType('TA', 'TA');
        $types->addType($traitA);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('TA'));
        $measuredTypeTA = $measuredTypes->get('TA');
        /** @var MetricValue $metricValue */
        $metricValue = $measuredTypeTA->getValue(Measurer::TRAIT_NOC);
        $this->assertEquals(0, $metricValue->getValue());
    }

    public function testMeasureTraitNOC1(): void
    {
        $types = new TypesCollection();

        $traitA = new TraitType('TA', 'TA');
        $types->addType($traitA);

        $classA = new ClassType('A', 'A');
        $classA->getTraits()->add($traitA);
        $types->addType($classA);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('TA'));
        $measuredTypeTA = $measuredTypes->get('TA');
        /** @var MetricValue $metricValue */
        $metricValue = $measuredTypeTA->getValue(Measurer::TRAIT_NOC);
        $this->assertEquals(1, $metricValue->getValue());
    }

    public function testMeasureTraitNOC2(): void
    {
        $types = new TypesCollection();

        $traitA = new TraitType('TA', 'TA');
        $types->addType($traitA);

        $classA = new ClassType('A', 'A');
        $classA->getTraits()->add($traitA);
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->getTraits()->add($traitA);
        $types->addType($classB);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('TA'));
        $measuredTypeTA = $measuredTypes->get('TA');
        /** @var MetricValue $metricValue */
        $metricValue = $measuredTypeTA->getValue(Measurer::TRAIT_NOC);
        $this->assertEquals(2, $metricValue->getValue());
    }

    public function testMeasureTraitNOC2OnlyDirectChilds(): void
    {
        $types = new TypesCollection();

        $traitA = new TraitType('TA', 'TA');
        $types->addType($traitA);

        $classA = new ClassType('A', 'A');
        $classA->getTraits()->add($traitA);
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->getTraits()->add($traitA);
        $types->addType($classB);

        $classC = new ClassType('C', 'C');
        $classC->setParent($classB);
        $types->addType($classC);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('TA'));
        $measuredTypeTA = $measuredTypes->get('TA');
        /** @var MetricValue $metricValue */
        $metricValue = $measuredTypeTA->getValue(Measurer::TRAIT_NOC);
        $this->assertEquals(2, $metricValue->getValue());
    }
}
