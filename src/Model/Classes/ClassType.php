<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ConstantCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\PropertyCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitCollectionInterface;

/**
 * Тип Класс
 * Class ClassType
 */
class ClassType implements ClassInterface
{
    private string $name;

    private string $fullName;

    private string $fileName = '';

    private bool $final = false;

    private bool $abstract = false;

    private ConstantCollection $constants;

    private PropertyCollection $properties;

    private MethodCollection $methods;

    private InterfaceCollection $expands;

    private TraitCollection $traits;

    private ?ClassInterface $parent = null;

    /**
     * ClassType constructor.
     * @param string $name
     * @param string $fullName
     * @param bool $final
     * @param bool $abstract
     */
    public function __construct(string $name, string $fullName, bool $final = false, bool $abstract = false)
    {
        $this->name = $name;
        $this->fullName = $fullName;
        $this->final = $final;
        $this->abstract = $abstract;

        $this->properties = new PropertyCollection();
        $this->constants = new ConstantCollection();
        $this->methods = new MethodCollection();

        $this->expands = new InterfaceCollection();
        $this->traits = new TraitCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * {@inheritDoc}
     */
    public function getProperties(): PropertyCollectionInterface
    {
        return $this->properties;
    }

    /**
     * {@inheritDoc}
     */
    public function getConstants(): ConstantCollectionInterface
    {
        return $this->constants;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethods(): MethodCollection
    {
        return $this->methods;
    }

    /**
     * {@inheritDoc}
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     * {@inheritDoc}
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * {@inheritDoc}
     */
    public function getExpands(): InterfaceCollection
    {
        return $this->expands;
    }

    /**
     * @param ClassInterface|null $parent
     */
    public function setParent(?ClassInterface $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent(): ?ClassInterface
    {
        return $this->parent;
    }

    /**
     * {@inheritDoc}
     */
    public function getTraits(): TraitCollectionInterface
    {
        return $this->traits;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }
}
