<?php

declare(strict_types=1);

namespace Tests\Metric\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Metric\Classes\ConstantCount;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\Constant;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\TraitType;

class ConstantCountTest extends TestCase
{
    public function testClassMeasure(): void
    {
        $metric = new ConstantCount();
        $class = new ClassType('name', 'name');

        $this->assertEquals(0, $metric->measure($class));

        $class->getConstants()->add(new Constant('A', $class));
        $this->assertEquals(1, $metric->measure($class));

        $class->getConstants()->add(new Constant('B', $class, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($class));

        $class->getConstants()->add(new Constant('C', $class, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($class));
    }

    public function testInterfaceMeasure(): void
    {
        $metric = new ConstantCount();
        $interfaceType = new InterfaceType('name', 'name');

        $this->assertEquals(0, $metric->measure($interfaceType));

        $interfaceType->getConstants()->add(new Constant('A', $interfaceType));
        $this->assertEquals(1, $metric->measure($interfaceType));

        $interfaceType->getConstants()->add(new Constant('B', $interfaceType, AccessibleInterface::ACCESS_PROTECTED));
        $this->assertEquals(2, $metric->measure($interfaceType));

        $interfaceType->getConstants()->add(new Constant('C', $interfaceType, AccessibleInterface::ACCESS_PRIVATE));
        $this->assertEquals(3, $metric->measure($interfaceType));
    }

    public function testTraitMeasure(): void
    {
        $metric = new ConstantCount();
        $interfaceType = new TraitType('name', 'name');

        $this->assertEquals(0, $metric->measure($interfaceType));
    }
}
