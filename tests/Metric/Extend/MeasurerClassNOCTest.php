<?php

declare(strict_types=1);

namespace Tests\Metric\Extend;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Extend\Measurer;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\TraitType;
use Suffi\PHPMetric\Model\TypesCollection;

class MeasurerClassNOCTest extends TestCase
{
    public function testMeasureClassNOC0(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeTA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeTA->getValue(Measurer::CLASS_NOC)->getValue());
    }

    public function testMeasureClassNOC1(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->setParent($classA);
        $types->addType($classB);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeTA = $measuredTypes->get('A');
        $this->assertEquals(1, $measuredTypeTA->getValue(Measurer::CLASS_NOC)->getValue());
    }

    public function testMeasureClassNOC2(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->setParent($classA);
        $types->addType($classB);

        $classC = new ClassType('C', 'C');
        $classC->setParent($classA);
        $types->addType($classC);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeTA = $measuredTypes->get('A');
        $this->assertEquals(2, $measuredTypeTA->getValue(Measurer::CLASS_NOC)->getValue());
    }

    public function testMeasureClassNOC2OnlyDirectChilds(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->setParent($classA);
        $types->addType($classB);

        $classC = new ClassType('C', 'C');
        $classC->setParent($classA);
        $types->addType($classC);

        $classD = new ClassType('D', 'D');
        $classD->setParent($classC);
        $types->addType($classD);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeTA = $measuredTypes->get('A');
        $this->assertEquals(2, $measuredTypeTA->getValue(Measurer::CLASS_NOC)->getValue());
    }
}
