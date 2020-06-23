<?php

declare(strict_types=1);

namespace Tests\Model\Classes;

use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Model\Classes\ClassType;

class ClassModelTest extends TestCase
{
    public function testName(): void
    {
        $class = new ClassType('name', 'fullName');
        $this->assertEquals('name', $class->getName());
    }
}
