<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ConstantInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;
use Suffi\PHPMetric\Model\Classes\Traits\AccessibleTrait;

/**
 * Константа
 * Class Constant
 */
class Constant implements ConstantInterface, AccessibleInterface
{
    use AccessibleTrait;

    private string $name = '';

    /**
     * @var ClassInterface|InterfaceInterface
     */
    private $type;

    /**
     * Constant constructor.
     *
     * @param  string        $name
     * @param  TypeInterface $type
     * @param  int           $accessType
     * @throws Exception
     */
    public function __construct(string $name, TypeInterface $type, int $accessType = AccessibleInterface::ACCESS_PUBLIC)
    {
        if (!$type instanceof ClassInterface && !$type instanceof InterfaceInterface) {
            throw new Exception("This type cannot have constants");
        }
        $this->name = $name;
        $this->type = $type;
        $this->accessType = $accessType;
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
     *
     * @return ClassInterface|InterfaceInterface
     */
    public function getType(): TypeInterface
    {
        return $this->type;
    }
}
