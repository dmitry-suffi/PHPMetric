<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\ConstantCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;

/**
 * Тип - Интерфейс
 * Class InterfaceType
 */
class InterfaceType implements InterfaceInterface
{
    private string $name;

    private string $fullName;

    private string $fileName = '';

    private ConstantCollection $constants;

    private MethodCollection $methods;

    private InterfaceCollection $expands;

    /**
     * InterfaceType constructor.
     * @param string $name
     * @param string $fullName
     */
    public function __construct(string $name, string $fullName)
    {
        $this->name = $name;
        $this->fullName = $fullName;

        $this->constants = new ConstantCollection();
        $this->methods = new MethodCollection();
        $this->expands = new InterfaceCollection();
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
    public function getExpands(): InterfaceCollectionInterface
    {
        return $this->expands;
    }
}