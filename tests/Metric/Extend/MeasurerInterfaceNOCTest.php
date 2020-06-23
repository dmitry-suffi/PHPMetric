<?php

declare(strict_types=1);

namespace Tests\Metric\Extend;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Extend\Measurer;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\TypesCollection;

class MeasurerInterfaceNOCTest extends TestCase
{
    public function testMeasureInterfaceNOC0(): void
    {
        $types = new TypesCollection();

        $interfaceA = new InterfaceType('IA', 'IA');
        $types->addType($interfaceA);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('IA'));
        $measuredTypeIA = $measuredTypes->get('IA');
        $this->assertEquals(0, $measuredTypeIA->getValue(Measurer::INTERFACE_NOC)->getValue());
    }

    public function testMeasureInterfaceNOC1(): void
    {
        $types = new TypesCollection();

        $interfaceA = new InterfaceType('IA', 'IA');
        $types->addType($interfaceA);

        $measurer = new Measurer();

        $classA = new ClassType('A', 'A');
        $classA->getExpands()->add($interfaceA);
        $types->addType($classA);

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('IA'));
        $measuredTypeIA = $measuredTypes->get('IA');
        $this->assertEquals(1, $measuredTypeIA->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(1, $measuredTypeIA->getValue(Measurer::INTERFACE_NOC)->getValue());
    }

    public function testMeasureInterfaceNOC2(): void
    {
        $types = new TypesCollection();

        $interfaceA = new InterfaceType('IA', 'IA');
        $types->addType($interfaceA);

        $measurer = new Measurer();

        $classA = new ClassType('A', 'A');
        $classA->getExpands()->add($interfaceA);
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->getExpands()->add($interfaceA);
        $types->addType($classB);

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('IA'));
        $measuredTypeIA = $measuredTypes->get('IA');
        $this->assertEquals(2, $measuredTypeIA->getValue(Measurer::INTERFACE_NOC)->getValue());
    }

    public function testMeasureInterfaceNOC2OnlyDirectChilds(): void
    {
        $types = new TypesCollection();

        $interfaceA = new InterfaceType('IA', 'IA');
        $types->addType($interfaceA);

        $measurer = new Measurer();

        $classA = new ClassType('A', 'A');
        $classA->getExpands()->add($interfaceA);
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->getExpands()->add($interfaceA);
        $types->addType($classB);

        $classC = new ClassType('C', 'C');
        $classC->setParent($classB);
        $types->addType($classC);

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('IA'));
        $measuredTypeIA = $measuredTypes->get('IA');
        // Только прямые потомки
        $this->assertEquals(2, $measuredTypeIA->getValue(Measurer::INTERFACE_NOC)->getValue());
    }
}
