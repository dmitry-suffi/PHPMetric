<?php

declare(strict_types=1);

namespace Tests\Model\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Model\Classes\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Method;
use Suffi\PHPMetric\Model\Classes\Property;

class MethodTest extends TestCase
{
    public function testProperty(): void
    {
        $method = new Method('name', $this->createMock(ClassInterface::class));

        $this->assertEquals('name', $method->getName());
        $this->assertTrue($method->isPublic());
    }

    public function testProtected(): void
    {
        $method = new Method('name', $this->createMock(ClassInterface::class), AccessibleInterface::ACCESS_PROTECTED);

        $this->assertTrue($method->isProtected());
        $this->assertFalse($method->isPublic());
        $this->assertFalse($method->isPrivate());
    }

    public function testStatic(): void
    {
        $method = new Method('name', $this->createMock(ClassInterface::class));
        $this->assertFalse($method->isStatic());
        $method = new Method(
            'name',
            $this->createMock(ClassInterface::class),
            AccessibleInterface::ACCESS_PROTECTED,
            true
        );
        $this->assertTrue($method->isStatic());
    }

    public function testFinal(): void
    {
        $method = new Method(
            'name',
            $this->createMock(ClassInterface::class),
            AccessibleInterface::ACCESS_PROTECTED,
            false,
            false
        );
        $this->assertFalse($method->isFinal());
        $method = new Method(
            'name',
            $this->createMock(ClassInterface::class),
            AccessibleInterface::ACCESS_PROTECTED,
            false,
            true
        );
        $this->assertTrue($method->isFinal());
    }
}
