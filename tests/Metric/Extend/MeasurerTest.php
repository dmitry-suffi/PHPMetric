<?php

namespace Tests\Metric\Extend;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Extend\Measurer;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\TraitType;
use Suffi\PHPMetric\Model\TypesCollection;

class MeasurerTest extends TestCase
{
    public function testMeasure(): void
    {
        $types = new TypesCollection();

        $interfaceA = new InterfaceType('IA', 'IA');
        $types->addType($interfaceA);

        $interfaceB = new InterfaceType('IB', 'IB');
        $interfaceA->getExpands()->add($interfaceB);
        $types->addType($interfaceB);

        $classA = new ClassType('A', 'A');
        $classA->getExpands()->add($interfaceB);
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

        $trait = new TraitType('TB', 'TB');
        $classB->getTraits()->add($trait);
        $types->addType($trait);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('IA'));
        $measuredTypeIA = $measuredTypes->get('IA');
        $this->assertEquals(0, $measuredTypeIA->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeIA->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeIA->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeIA->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('IB'));
        $measuredTypeIB = $measuredTypes->get('IB');
        $this->assertEquals(1, $measuredTypeIB->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeIB->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeIB->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeIB->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('TB'));
        $measuredTypeTB = $measuredTypes->get('TB');
        $this->assertEquals(0, $measuredTypeTB->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(1, $measuredTypeTB->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeTB->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeTB->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(2, $measuredTypeA->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('B'));
        $measuredTypeB = $measuredTypes->get('B');
        $this->assertEquals(0, $measuredTypeB->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeB->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeB->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(1, $measuredTypeB->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('C'));
        $measuredTypeC = $measuredTypes->get('C');
        $this->assertEquals(0, $measuredTypeC->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeC->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(1, $measuredTypeC->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(1, $measuredTypeC->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('D'));
        $measuredTypeD = $measuredTypes->get('D');
        $this->assertEquals(0, $measuredTypeD->getValue(Measurer::INTERFACE_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeD->getValue(Measurer::TRAIT_NOC)->getValue());
        $this->assertEquals(0, $measuredTypeD->getValue(Measurer::CLASS_NOC)->getValue());
        $this->assertEquals(2, $measuredTypeD->getValue(Measurer::CLASS_DIT)->getValue());
    }
}
