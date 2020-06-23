<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\MethodInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;
use Suffi\PHPMetric\Model\Classes\Traits\AccessibleTrait;

/**
 * Метод
 * Class Method
 */
class Method implements MethodInterface, AccessibleInterface
{
    use AccessibleTrait;

    private string $name;

    /**
     * @var ClassInterface|TraitInterface
     */
    private  $type;

    private bool $static = false;

    private bool $final = false;

    private bool $abstract = false;

    /**
     * Method constructor.
     * @param string $name
     * @param TypeInterface $type
     * @param int $accessType
     * @param bool $static
     * @param bool $final
     */
    public function __construct(string $name, TypeInterface $type, int $accessType = AccessibleInterface::ACCESS_PUBLIC, bool $static = false, bool $final = false, bool $abstract = false)
    {
        $this->name = $name;
        if (!in_array($accessType, [AccessibleInterface::ACCESS_PUBLIC, AccessibleInterface::ACCESS_PROTECTED, AccessibleInterface::ACCESS_PRIVATE])) {
            $accessType = AccessibleInterface::ACCESS_PUBLIC;
        }

        $this->accessType = $accessType;
        $this->type = $type;
        $this->static = $static;
        $this->final = $final;
        $this->abstract = $abstract;
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
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->static;
    }

    /**
     * @return bool
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
}
