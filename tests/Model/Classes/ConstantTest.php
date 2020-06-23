<?php

declare(strict_types=1);

namespace Tests\Model\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Model\Classes\Constant;
use Suffi\PHPMetric\Model\Classes\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;

class ConstantTest extends TestCase
{
    public function testConstant(): void
    {
        $constant = new Constant('test', $this->createMock(ClassInterface::class));

        $this->assertEquals('test', $constant->getName());
        $this->assertTrue($constant->isPublic());
    }

    public function testProtected(): void
    {
        $constant = new Constant(
            'test',
            $this->createMock(ClassInterface::class),
            AccessibleInterface::ACCESS_PROTECTED
        );

        $this->assertTrue($constant->isProtected());
        $this->assertFalse($constant->isPublic());
        $this->assertFalse($constant->isPrivate());
    }

    public function testTraitException(): void
    {
        $this->expectException(Exception::class);
        $constant = new Constant('test', $this->createMock(TraitInterface::class));
    }
}
