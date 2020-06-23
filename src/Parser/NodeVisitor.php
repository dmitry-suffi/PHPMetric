<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Parser;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use Suffi\PHPMetric\Model\Classes\ClassType;
use Suffi\PHPMetric\Model\Classes\Constant;
use Suffi\PHPMetric\Model\Classes\External\HavingUseCasesInterface;
use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;
use Suffi\PHPMetric\Model\Classes\InterfaceType;
use Suffi\PHPMetric\Model\Classes\Method;
use Suffi\PHPMetric\Model\Classes\Property;
use Suffi\PHPMetric\Model\Classes\TraitType;
use Suffi\PHPMetric\Model\TypesCollection;

//@todo refactoring
class NodeVisitor extends NodeVisitorAbstract
{
    private TypesCollection $types;

    private TypesCollection $externalTypes;

    private ?TypeInterface $currentType = null;

    private string $file = '';

    private TraitUseCaseHandler $traitUseCaseHandler;

    private ClassExpandUseCaseHandler $classExpandUseCaseHandler;

    private ClassExtendUseCaseHandler $classExtendUseCaseHandler;

    private InterfaceExtendUseCaseHandler $interfaceExtendUseCaseHandler;

    public function __construct()
    {
        $this->types = new TypesCollection();
        $this->externalTypes = new TypesCollection();

        $this->traitUseCaseHandler = new TraitUseCaseHandler();
        $this->classExpandUseCaseHandler = new ClassExpandUseCaseHandler();
        $this->classExtendUseCaseHandler = new ClassExtendUseCaseHandler();
        $this->interfaceExtendUseCaseHandler = new InterfaceExtendUseCaseHandler();
    }

    /**
     * @param string $file
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * @return TypesCollection
     */
    public function getTypes(): TypesCollection
    {
        return $this->types;
    }

    /**
     * @return TypesCollection
     */
    public function getExternalTypes(): TypesCollection
    {
        return $this->externalTypes;
    }

    public function beforeTraverse(array $nodes)
    {
        return null;
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\ClassLike) {
            if ($node instanceof Node\Stmt\Class_) {
                //@todo пропускаем анонимные
                if ($node->isAnonymous()) {
                    return NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                $this->currentType = $this->createClass($node);
            } else if ($node instanceof Node\Stmt\Trait_) {
                $this->currentType = $this->createTrait($node);
            } else if ($node instanceof Node\Stmt\Interface_) {
                $this->currentType = $this->createInterface($node);
            }

            /** Ранее встречали тип */
            $this->alreadyFound();

            $this->currentType->setFileName($this->file);
            $this->types->addType($this->currentType);
        }

        return null;
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof Node\Stmt\ClassLike) {
            if ($node instanceof Node\Stmt\Class_ && $node->isAnonymous()) {
                return null;
            }
        }

        if ($this->currentType) {
            if ($node instanceof Node\Stmt\Property) {
                if ($this->currentType instanceof ClassInterface || $this->currentType instanceof TraitInterface) {
                    $this->currentType->getProperties()->add($this->createProperty($node));
                }
            }

            if ($node instanceof Node\Stmt\ClassConst) {
                if ($this->currentType instanceof ClassInterface || $this->currentType instanceof InterfaceType) {
                    $this->currentType->getConstants()->add($this->createConstant($node));
                }
            }

            if ($node instanceof Node\Stmt\ClassMethod) {
                $this->currentType->getMethods()->add($this->createMethod($node));
            }
        }

        if ($node instanceof Node\Stmt\Class_) {
            if ($node->getTraitUses()) {
                foreach ($node->getTraitUses() as $traitUse) {
                    foreach ($traitUse->traits as $traitUse) {
                        $this->useCase($this->traitUseCaseHandler, $traitUse->getLast(), (string)$traitUse);
                    }
                }
            }
            if ($node->implements) {
                foreach ($node->implements as $implement) {
                    $this->useCase($this->classExpandUseCaseHandler, $implement->getLast(), (string)$implement);
                }
            }
            if ($node->extends) {
                $this->useCase($this->classExtendUseCaseHandler, $node->extends->getLast(), (string)$node->extends);
            }
        }

        if ($node instanceof Node\Stmt\Interface_) {
            if ($node->extends) {
                foreach ($node->extends as $extend) {
                    $this->useCase($this->interfaceExtendUseCaseHandler, $extend->getLast(), (string)$extend);
                }
            }
        }

        if ($node instanceof Node\Stmt\ClassLike) {
            $name = (string)$node->namespacedName;
            if (!is_null($this->currentType) && $this->currentType->getName() === $name) {
                $this->currentType = null;
            }
        }

        return null;
    }

    public function useCase(UseCaseHandlerInterface $object, string $name, string $fullName): void
    {
        // Уже прочитан
        if ($this->types->has($fullName)) {
            /** @var TypeInterface $type */
            $type = $this->types->get($fullName);
            /** Проверяем соответствие типов */
            $object->checkType($type);
            /** Добавляем */
            $object->add($this->currentType, $type);
        } else if ($this->externalTypes->has($fullName)) {  //Неизвестный, но уже встречался, тянем из externalTypes
            /** @var HavingUseCasesInterface&TypeInterface $externalType */
            $externalType = $this->externalTypes->get($fullName);
            /** Проверяем соответствие типов */
            $object->checkType($externalType);
            /** Добавляем */
            $object->add($this->currentType, $externalType);
            /** И отмечаем использование */
            $externalType->addUseCase($object->createUseCase($this->currentType, $externalType));
        } else { // Первый раз встречаем, создаем новый externalType
            /** @var HavingUseCasesInterface&TypeInterface $externalType */
            $externalType = $object->createType($name, $fullName);
            $this->externalTypes->addType($externalType);
            /** Добавляем */
            $object->add($this->currentType, $externalType);
            /** И отмечаем использование */
            /** @var HavingUseCasesInterface $externalType */
            $externalType->addUseCase($object->createUseCase($this->currentType, $externalType));
        }
    }

    /**
     * Создание класса
     * @param Node\Stmt\Class_ $node
     * @return ClassType
     */
    public function createClass(Node\Stmt\Class_ $node): ClassType
    {
        $classType = new ClassType(
            $node->name->name,
            (string)$node->namespacedName,
            $node->isFinal()
        );

        return $classType;
    }

    /**
     * Создание трейта
     * @param Node\Stmt\Trait_ $node
     * @return TraitType
     */
    public function createTrait(Node\Stmt\Trait_ $node): TraitType
    {
        return new TraitType(
            $node->name->name,
            (string)$node->namespacedName
        );
    }

    /**
     * Создание интерфейса
     * @param Node\Stmt\Interface_ $node
     * @return InterfaceType
     */
    public function createInterface(Node\Stmt\Interface_ $node): InterfaceType
    {
        $interfaceType = new InterfaceType(
            $node->name->name,
            (string)$node->namespacedName
        );

        return $interfaceType;
    }

    /**
     * Создание константы
     * @param Node\Stmt\ClassConst $node
     * @return Constant
     * @throws \Suffi\PHPMetric\Model\Classes\Exception
     */
    protected function createConstant(Node\Stmt\ClassConst $node): Constant
    {
        if ($node->isPrivate()) {
            $access = AccessibleInterface::ACCESS_PRIVATE;
        } else if ($node->isProtected()) {
            $access = AccessibleInterface::ACCESS_PROTECTED;
        } else {
            $access = AccessibleInterface::ACCESS_PUBLIC;
        }

        return new Constant(
            $node->consts[0]->name->name,
            $this->currentType,
            $access
        );
    }

    /**
     * Создание метода
     * @param Node\Stmt\ClassMethod $node
     * @return Method
     * @throws \Suffi\PHPMetric\Model\Classes\Exception
     */
    protected function createMethod(Node\Stmt\ClassMethod $node): Method
    {
        if ($node->isPrivate()) {
            $access = AccessibleInterface::ACCESS_PRIVATE;
        } else if ($node->isProtected()) {
            $access = AccessibleInterface::ACCESS_PROTECTED;
        } else {
            $access = AccessibleInterface::ACCESS_PUBLIC;
        }

        return new Method(
            $node->name->name,
            $this->currentType,
            $access,
            $node->isStatic(),
            $node->isFinal()
        );
    }

    /**
     * Создание свойства
     * @param Node\Stmt\Property $node
     * @return Property
     * @throws \Suffi\PHPMetric\Model\Classes\Exception
     */
    protected function createProperty(Node\Stmt\Property $node): Property
    {
        if ($node->isPrivate()) {
            $access = AccessibleInterface::ACCESS_PRIVATE;
        } else if ($node->isProtected()) {
            $access = AccessibleInterface::ACCESS_PROTECTED;
        } else {
            $access = AccessibleInterface::ACCESS_PUBLIC;
        }

        return new Property(
            $node->props[0]->name->name,
            $this->currentType,
            $access,
            $node->isStatic()
        );
    }

    protected function alreadyFound(): void
    {
        $fullName = $this->currentType->getFullName();
        if ($this->externalTypes->has($fullName)) {
            /** @var HavingUseCasesInterface $externalType */
            $externalType = $this->externalTypes->get($fullName);
            if ($externalType instanceof HavingUseCasesInterface) {
                /** @var UseCaseInterface $useCase */
                foreach ($externalType->getUseCases() as $useCase) {
                    if (!$useCase->isDefined()) {
                        $useCase->define($this->currentType);
                    }
                }
                if ($externalType->isDefined()) {
                    $this->externalTypes->delete($fullName);
                }
            }
        }
    }
}
