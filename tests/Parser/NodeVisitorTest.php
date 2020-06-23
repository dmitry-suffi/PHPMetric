<?php

declare(strict_types=1);

namespace Tests\Parser;

use PhpParser\NodeVisitor\NameResolver;
use PHPUnit\Framework\TestCase;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\Constant;
use Suffi\PHPMetric\Model\Classes\External\ExternalClassType;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\Method;
use Suffi\PHPMetric\Model\Classes\Property;
use Suffi\PHPMetric\Model\Classes\TraitType;
use Suffi\PHPMetric\Model\TypesCollection;
use Suffi\PHPMetric\Parser\NodeVisitor;

class NodeVisitorTest extends TestCase
{
    /**
     * @return string
     */
    protected function getFixturesPath(): string
    {
        return __DIR__ . '/../Fixtures/';
    }

    protected function parseFile(string $fileNameWithExtension, string $absoluteFilePath): TypesCollection
    {
        $parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);

        $traverser = new \PhpParser\NodeTraverser();

        $visitor = new NodeVisitor();
        $traverser->addVisitor(new NameResolver(null, ['replaceNodes' => true]));
        $traverser->addVisitor($visitor);

        $visitor->setFile($fileNameWithExtension);
        $contents = file_get_contents($absoluteFilePath);
        if (false === $contents) {
            throw new \Exception(sprintf("File %s not found", $absoluteFilePath));
        }
        $ast = $parser->parse($contents);

        if (null === $ast) {
            throw new \Exception(sprintf("File %s not parse AST", $absoluteFilePath));
        }
        $traverser->traverse($ast);

        return $visitor->getTypes();
    }

    public function testCreateInterface(): void
    {
        $typesCollection = $this->parseFile('FooInterface.php', $this->getFixturesPath() . 'Foo/FooInterface.php');

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var InterfaceType $interfaceType */
        $interfaceType = $types[array_key_first($types)];

        // Consts
        $this->assertInstanceOf(InterfaceType::class, $interfaceType);
        $this->assertEquals('FooInterface', $interfaceType->getName());
        $this->assertEquals('Tests\Fixtures\Foo\FooInterface', $interfaceType->getFullName());
        $this->assertEquals('FooInterface.php', $interfaceType->getFileName());

        $this->assertCount(1, $interfaceType->getConstants());
        $this->assertTrue($interfaceType->getConstants()->has('I_FOO'));

        /** @var Constant $constant */
        $constant = $interfaceType->getConstants()->get('I_FOO');
        $this->assertEquals('I_FOO', $constant->getName());
        $this->assertEquals($interfaceType, $constant->getType());
        $this->assertTrue($constant->isPublic());

        //Methods
        $this->assertCount(1, $interfaceType->getMethods());
        $this->assertTrue($interfaceType->getMethods()->has('foo'));

        /** @var Method $method */
        $method = $interfaceType->getMethods()->get('foo');
        $this->assertEquals('foo', $method->getName());
        $this->assertEquals($interfaceType, $method->getType());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isFinal());
        $this->assertFalse($method->isStatic());
    }

    public function testCreateTrait(): void
    {
        $typesCollection = $this->parseFile('FooTrait.php', $this->getFixturesPath() . 'Foo/FooTrait.php');

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var TraitType $traitType */
        $traitType = $types[array_key_first($types)];

        $this->assertInstanceOf(TraitType::class, $traitType);
        $this->assertEquals('FooTrait', $traitType->getName());
        $this->assertEquals('Tests\Fixtures\Foo\FooTrait', $traitType->getFullName());
        $this->assertEquals('FooTrait.php', $traitType->getFileName());

        //Properties
        $this->assertCount(1, $traitType->getProperties());
        $this->assertTrue($traitType->getProperties()->has('tFoo'));

        /** @var Property $property */
        $property = $traitType->getProperties()->get('tFoo');
        $this->assertEquals('tFoo', $property->getName());
        $this->assertEquals($traitType, $property->getType());
        $this->assertTrue($property->isProtected());
        $this->assertFalse($property->isStatic());

        //Methods
        $this->assertCount(1, $traitType->getMethods());
        $this->assertTrue($traitType->getMethods()->has('tFoo'));

        /** @var Method $method */
        $method = $traitType->getMethods()->get('tFoo');
        $this->assertEquals('tFoo', $method->getName());
        $this->assertEquals($traitType, $method->getType());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isFinal());
        $this->assertFalse($method->isStatic());
    }

    public function testCreateClass(): void
    {
        $typesCollection = $this->parseFile('Foo.php', $this->getFixturesPath() . 'Foo/Foo.php');

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var ClassType $classType */
        $classType = $types[array_key_first($types)];

        //Consts
        $this->assertCount(1, $classType->getConstants());
        $this->assertTrue($classType->getConstants()->has('C_FOO'));

        /** @var Constant $constant */
        $constant = $classType->getConstants()->get('C_FOO');
        $this->assertEquals('C_FOO', $constant->getName());
        $this->assertEquals($classType, $constant->getType());
        $this->assertTrue($constant->isProtected());

        //Properties
        $this->assertCount(2, $classType->getProperties());

        $this->assertTrue($classType->getProperties()->has('bar'));
        /** @var Property $property */
        $property = $classType->getProperties()->get('bar');
        $this->assertEquals('bar', $property->getName());
        $this->assertEquals($classType, $property->getType());
        $this->assertTrue($property->isProtected());
        $this->assertFalse($property->isStatic());

        $this->assertTrue($classType->getProperties()->has('barStatic'));
        /** @var Property $property */
        $property = $classType->getProperties()->get('barStatic');
        $this->assertEquals('barStatic', $property->getName());
        $this->assertEquals($classType, $property->getType());
        $this->assertTrue($property->isProtected());
        $this->assertTrue($property->isStatic());

        //Methods
        $this->assertCount(3, $classType->getMethods());

        $this->assertTrue($classType->getMethods()->has('getBar'));
        /** @var Method $method */
        $method = $classType->getMethods()->get('getBar');
        $this->assertEquals('getBar', $method->getName());
        $this->assertEquals($classType, $method->getType());
        $this->assertTrue($method->isProtected());
        $this->assertTrue($method->isFinal());
        $this->assertFalse($method->isStatic());

        $this->assertTrue($classType->getMethods()->has('getBarStatic'));
        /** @var Method $method */
        $method = $classType->getMethods()->get('getBarStatic');
        $this->assertEquals('getBarStatic', $method->getName());
        $this->assertEquals($classType, $method->getType());
        $this->assertTrue($method->isPrivate());
        $this->assertFalse($method->isFinal());
        $this->assertTrue($method->isStatic());

        $this->assertTrue($classType->getMethods()->has('foo'));
        /** @var Method $method */
        $method = $classType->getMethods()->get('foo');
        $this->assertEquals('foo', $method->getName());
        $this->assertEquals($classType, $method->getType());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isFinal());
        $this->assertFalse($method->isStatic());
    }

    public function testInterfaceExpands(): void
    {
        $typesCollection = $this->parseFile(
            'FooBarInterface.php',
            $this->getFixturesPath() . 'Foo/FooBarInterface.php'
        );

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var InterfaceType $interfaceType */
        $interfaceType = $types[array_key_first($types)];

        $interfaceCollection = $interfaceType->getExpands();
        $this->assertEquals(1, $interfaceCollection->count());

        $this->assertTrue($interfaceCollection->has('Tests\Fixtures\Foo\FooInterface'));
        $expand = $interfaceCollection->get('Tests\Fixtures\Foo\FooInterface');
        $this->assertEquals('Tests\Fixtures\Foo\FooInterface', $expand->getFullName());
    }

    public function testClassExpands(): void
    {
        $typesCollection = $this->parseFile('Foo.php', $this->getFixturesPath() . 'Foo/Foo.php');

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var ClassType $classType */
        $classType = $types[array_key_first($types)];

        $interfaceCollection = $classType->getExpands();
        $this->assertEquals(1, $interfaceCollection->count());

        $this->assertTrue($interfaceCollection->has('Tests\Fixtures\Foo\FooInterface'));
        $expand = $interfaceCollection->get('Tests\Fixtures\Foo\FooInterface');
        $this->assertEquals('Tests\Fixtures\Foo\FooInterface', $expand->getFullName());
    }

    public function testClassParent(): void
    {
        $typesCollection = $this->parseFile('ConcreteFoo.php', $this->getFixturesPath() . 'ConcreteFoo.php');

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var ClassType $classType */
        $classType = $types[array_key_first($types)];

        $parentClass = $classType->getParent();
        $this->assertNotNull($parentClass);
        /** @var ClassInterface $parentClass */
        $this->assertEquals('Tests\Fixtures\Foo\Foo', $parentClass->getFullName());
    }

    public function testClassUsedTrait(): void
    {
        $typesCollection = $this->parseFile('ConcreteFoo.php', $this->getFixturesPath() . 'ConcreteFoo.php');

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);

        /** @var ClassType $classType */
        $classType = $types[array_key_first($types)];

        $traits = $classType->getTraits();
        $this->assertEquals(1, $traits->count());

        $this->assertTrue($traits->has('Tests\Fixtures\Foo\FooTrait'));
        $trait = $traits->get('Tests\Fixtures\Foo\FooTrait');
        $this->assertEquals('Tests\Fixtures\Foo\FooTrait', $trait->getFullName());
    }

    public function testClassParentLoading(): void
    {
        $parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);

        $traverser = new \PhpParser\NodeTraverser();

        $visitor = new NodeVisitor();
        $traverser->addVisitor(new NameResolver(null, ['replaceNodes' => true]));
        $traverser->addVisitor($visitor);

        $visitor->setFile('ConcreteFoo.php');

        $contents = file_get_contents($this->getFixturesPath() . 'ConcreteFoo.php');
        if (false === $contents) {
            throw new \Exception(sprintf("File %s not found", $this->getFixturesPath() . 'ConcreteFoo.php'));
        }
        $ast = $parser->parse($contents);

        if (null === $ast) {
            throw new \Exception(sprintf("File %s not parse AST", $this->getFixturesPath() . 'ConcreteFoo.php'));
        }
        $traverser->traverse($ast);

        $typesCollection = $visitor->getTypes();

        $types = $typesCollection->getTypes();
        $this->assertCount(1, $types);
        $this->assertCount(2, $visitor->getExternalTypes()->getTypes());
        $this->assertTrue($visitor->getExternalTypes()->has('Tests\Fixtures\Foo\Foo'));

        /** @var ClassType $classType */
        $classType = $types['Tests\Fixtures\ConcreteFoo'];

        $parentClass = $classType->getParent();
        $this->assertNotNull($parentClass);
        /** @var ClassInterface $parentClass */
        $this->assertEquals('Tests\Fixtures\Foo\Foo', $parentClass->getFullName());
        $this->assertInstanceOf(ExternalClassType::class, $parentClass);

        /** Читаем второй файл */
        $visitor->setFile('Foo.php');

        $contents = file_get_contents($this->getFixturesPath() . 'Foo/Foo.php');
        if (false === $contents) {
            throw new \Exception(sprintf("File %s not found", $this->getFixturesPath() . 'Foo/Foo.php'));
        }
        $ast = $parser->parse($contents);

        if (null === $ast) {
            throw new \Exception(sprintf("File %s not parse AST", $this->getFixturesPath() . 'Foo/Foo.php'));
        }
        $traverser->traverse($ast);

        $typesCollection = $visitor->getTypes();
        $types = $typesCollection->getTypes();
        $this->assertCount(2, $types);
        // Foo определили, но добавился FooInterface
        $this->assertCount(2, $visitor->getExternalTypes()->getTypes());
        $this->assertFalse($visitor->getExternalTypes()->has('Tests\Fixtures\Foo\Foo'));

        /** @var ClassInterface $classType */
        $classType = $types['Tests\Fixtures\ConcreteFoo'];

        $parentClass = $classType->getParent();
        $this->assertNotNull($parentClass);
        /** @var ClassInterface $parentClass */
        $this->assertEquals('Tests\Fixtures\Foo\Foo', $parentClass->getFullName());
        $this->assertNotInstanceOf(ExternalClassType::class, $parentClass);
    }
}
