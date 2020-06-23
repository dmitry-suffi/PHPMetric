<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\PropertyInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;
use Suffi\PHPMetric\Model\Classes\Traits\AccessibleTrait;

/**
 * Свойство
 * Class Property
 */
class Property implements PropertyInterface, AccessibleInterface
{
    use AccessibleTrait;

    private string $name;

    /**
     * @var ClassInterface|TraitInterface
     */
    private $type;

    private bool $static = false;

    /**
     * Property constructor.
     *
     * @param string $name
     * @param TypeInterface $type
     * @param int $accessType
     * @param bool $static
     * @throws Exception
     */
    public function __construct(
        string $name,
        TypeInterface $type,
        int $accessType = AccessibleInterface::ACCESS_PUBLIC,
        bool $static = false
    ) {
        $this->name = $name;
        if (!in_array($accessType, AccessibleInterface::ACCESS_LIST)) {
            $accessType = AccessibleInterface::ACCESS_PUBLIC;
        }

        if (!$type instanceof ClassInterface && !$type instanceof TraitInterface) {
            throw new Exception("This type cannot have properties");
        }

        $this->accessType = $accessType;
        $this->type = $type;
        $this->static = $static;
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
    public function getType(): TypeInterface
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function isStatic(): bool
    {
        return $this->static;
    }
}
