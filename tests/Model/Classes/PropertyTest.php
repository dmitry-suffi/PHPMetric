<?php declare(strict_types=1);

namespace Tests\Model\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Model\Classes\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Property;

class PropertyTest extends TestCase
{
    public function testProperty(): void
    {
        $property = new Property('name', $this->createMock(ClassInterface::class));

        $this->assertEquals('name', $property->getName());
        $this->assertTrue($property->isPublic());
    }

    public function testProtected(): void
    {
        $property = new Property('name', $this->createMock(ClassInterface::class), AccessibleInterface::ACCESS_PROTECTED);

        $this->assertTrue($property->isProtected());
        $this->assertFalse($property->isPublic());
        $this->assertFalse($property->isPrivate());
    }

    public function testTraitException(): void
    {
        $this->expectException(Exception::class);
        $property = new Property('test', $this->createMock(InterfaceInterface::class));
    }

    public function testStatic(): void
    {
        $property = new Property('name', $this->createMock(ClassInterface::class));
        $this->assertFalse($property->isStatic());
        $property = new Property('name', $this->createMock(ClassInterface::class), AccessibleInterface::ACCESS_PROTECTED, true);
        $this->assertTrue($property->isStatic());
    }
}
