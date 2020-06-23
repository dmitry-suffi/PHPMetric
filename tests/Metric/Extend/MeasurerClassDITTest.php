<?php

namespace Tests\Metric\Extend;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Extend\Measurer;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\TraitType;
use Suffi\PHPMetric\Model\TypesCollection;

class MeasurerClassDITTest extends TestCase
{
    public function testMeasureClassDIT0(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeTA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeTA->getValue(Measurer::CLASS_DIT)->getValue());
    }

    public function testMeasureClassDIT1(): void
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
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('B'));
        $measuredTypeB = $measuredTypes->get('B');
        $this->assertEquals(1, $measuredTypeB->getValue(Measurer::CLASS_DIT)->getValue());
    }

    public function testMeasureClassDIT2(): void
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
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('B'));
        $measuredTypeB = $measuredTypes->get('B');
        $this->assertEquals(1, $measuredTypeB->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('C'));
        $measuredTypeC = $measuredTypes->get('C');
        $this->assertEquals(1, $measuredTypeC->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('D'));
        $measuredTypeD = $measuredTypes->get('D');
        $this->assertEquals(2, $measuredTypeD->getValue(Measurer::CLASS_DIT)->getValue());
    }

    public function testMeasureClassDIT0Trait(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $trait = new TraitType('TA', 'TA');
        $classA->getTraits()->add($trait);
        $types->addType($trait);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());
    }

    public function testMeasureClassDIT1Trait(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->setParent($classA);
        $types->addType($classB);

        $trait = new TraitType('TB', 'TB');
        $classB->getTraits()->add($trait);
        $types->addType($trait);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('B'));
        $measuredTypeB = $measuredTypes->get('B');
        $this->assertEquals(1, $measuredTypeB->getValue(Measurer::CLASS_DIT)->getValue());
    }

    public function testMeasureClassDIT0Interface(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $interface = new InterfaceType('IA', 'IA');
        $classA->getExpands()->add($interface);
        $types->addType($interface);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());
    }

    public function testMeasureClassDIT1Interface(): void
    {
        $types = new TypesCollection();

        $classA = new ClassType('A', 'A');
        $types->addType($classA);

        $classB = new ClassType('B', 'B');
        $classB->setParent($classA);
        $types->addType($classB);

        $interface = new InterfaceType('IB', 'IB');
        $classB->getExpands()->add($interface);
        $types->addType($interface);

        $measurer = new Measurer();

        $measuredTypes = $measurer->measureTypes($types);
        $this->assertTrue($measuredTypes->has('A'));
        $measuredTypeA = $measuredTypes->get('A');
        $this->assertEquals(0, $measuredTypeA->getValue(Measurer::CLASS_DIT)->getValue());

        $this->assertTrue($measuredTypes->has('B'));
        $measuredTypeB = $measuredTypes->get('B');
        $this->assertEquals(1, $measuredTypeB->getValue(Measurer::CLASS_DIT)->getValue());
    }
}
