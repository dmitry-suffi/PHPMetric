<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\PropertyCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;

/**
 * Тип - Трейт
 * Class TraitType
 */
class TraitType implements TraitInterface
{
    private string $name;

    private string $fullName;

    private string $fileName = '';

    private PropertyCollection $properties;

    private MethodCollection $methods;

    private TraitCollection $traits;

    public function __construct(string $name, string $fullName)
    {
        $this->name = $name;
        $this->fullName = $fullName;

        $this->properties = new PropertyCollection();
        $this->methods = new MethodCollection();
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
    public function getMethods(): MethodCollection
    {
        return $this->methods;
    }

    /**
     * {@inheritDoc}
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

    /**
     * {@inheritDoc}
     */
    public function getTraits(): TraitCollectionInterface
    {
        return $this->traits;
    }
}
