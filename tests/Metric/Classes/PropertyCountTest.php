<?php

declare(strict_types=1);

namespace Tests\Metric\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Classes\ConstantCount;
use Suffi\PHPMetric\Metric\Classes\MethodCount;
use Suffi\PHPMetric\Metric\Classes\PropertyCount;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\Constant;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\Property;
use Suffi\PHPMetric\Model\Classes\TraitType;

class PropertyCountTest extends TestCase
{
    public function testClassMeasure(): void
    {
        $metric = new PropertyCount();
        $class = new ClassType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));

        $class->getProperties()->add(new Property('A', $class));
        $this->assertEquals(1, $metric->measure($class));

        $class->getProperties()->add(new Property('B', $class, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($class));

        $class->getProperties()->add(new Property('C', $class, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($class));

        $class->getProperties()->add(new Property('D', $class, AccessibleInterface::ACCESS_PRIVATE, true));
        $this->assertEquals(4, $metric->measure($class));
    }

    public function testTraitMeasure(): void
    {
        $metric = new PropertyCount();
        $class = new TraitType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));

        $class->getProperties()->add(new Property('A', $class));
        $this->assertEquals(1, $metric->measure($class));

        $class->getProperties()->add(new Property('B', $class, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($class));

        $class->getProperties()->add(new Property('C', $class, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($class));

        $class->getProperties()->add(new Property('D', $class, AccessibleInterface::ACCESS_PRIVATE, true));
        $this->assertEquals(4, $metric->measure($class));
    }

    public function testInterfaceMeasure(): void
    {
        $metric = new PropertyCount();
        $class = new InterfaceType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));
    }
}
