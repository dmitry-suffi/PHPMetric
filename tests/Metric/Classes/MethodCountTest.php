<?php

namespace Tests\Metric\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Classes\MethodCount;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\Method;
use Suffi\PHPMetric\Model\Classes\TraitType;

class MethodCountTest extends TestCase
{
    public function testClassMeasure(): void
    {
        $metric = new MethodCount();
        $class = new ClassType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));

        $class->getMethods()->add(new Method('A', $class));
        $this->assertEquals(1, $metric->measure($class));

        $class->getMethods()->add(new Method('B', $class, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($class));

        $class->getMethods()->add(new Method('C', $class, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($class));

        $class->getMethods()->add(new Method('D', $class, AccessibleInterface::ACCESS_PUBLIC, true));
        $this->assertEquals(4, $metric->measure($class));

        $class->getMethods()->add(new Method('E', $class, AccessibleInterface::ACCESS_PUBLIC, false, true));
        $this->assertEquals(5, $metric->measure($class));

        $class->getMethods()->add(new Method('F', $class, AccessibleInterface::ACCESS_PUBLIC, false, true, true));
        $this->assertEquals(6, $metric->measure($class));
    }

    public function testInterfaceMeasure(): void
    {
        $metric = new MethodCount();
        $class = new InterfaceType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));

        $class->getMethods()->add(new Method('A', $class));
        $this->assertEquals(1, $metric->measure($class));

        $class->getMethods()->add(new Method('B', $class, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($class));

        $class->getMethods()->add(new Method('C', $class, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($class));

        $class->getMethods()->add(new Method('D', $class, AccessibleInterface::ACCESS_PUBLIC, true));
        $this->assertEquals(4, $metric->measure($class));

        $class->getMethods()->add(new Method('E', $class, AccessibleInterface::ACCESS_PUBLIC, false, true));
        $this->assertEquals(5, $metric->measure($class));

        $class->getMethods()->add(new Method('F', $class, AccessibleInterface::ACCESS_PUBLIC, false, true, true));
        $this->assertEquals(6, $metric->measure($class));
    }

    public function testTraitMeasure(): void
    {
        $metric = new MethodCount();
        $class = new TraitType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));

        $class->getMethods()->add(new Method('A', $class));
        $this->assertEquals(1, $metric->measure($class));

        $class->getMethods()->add(new Method('B', $class, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($class));

        $class->getMethods()->add(new Method('C', $class, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($class));

        $class->getMethods()->add(new Method('D', $class, AccessibleInterface::ACCESS_PUBLIC, true));
        $this->assertEquals(4, $metric->measure($class));

        $class->getMethods()->add(new Method('E', $class, AccessibleInterface::ACCESS_PUBLIC, false, true));
        $this->assertEquals(5, $metric->measure($class));

        $class->getMethods()->add(new Method('F', $class, AccessibleInterface::ACCESS_PUBLIC, false, true, true));
        $this->assertEquals(6, $metric->measure($class));
    }
}
