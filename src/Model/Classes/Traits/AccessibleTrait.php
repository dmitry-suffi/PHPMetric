<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Traits;

use Suffi\PHPMetric\Model\Classes\Interfaces\AccessibleInterface;

/**
 * Вспомогательный трейт с методами для реализации AccessibleInterface
 * Trait AccessibleTrait
 */
trait AccessibleTrait
{
    /**
     * Уровень доступа
     * @var int
     */
    protected int $accessType = AccessibleInterface::ACCESS_PUBLIC;

    /**
     * Возвращает уровень доступа в виде числа AccessibleInterface::ACCESS_PUBLIC | AccessibleInterface::ACCESS_PROTECTED | AccessibleInterface::ACCESS_PRIVATE
     * @return int
     */
    public function getAccessType(): int
    {
        return $this->accessType;
    }

    /**
     * Уровень доступа - публичный
     * @return bool
     */
    public function isPublic(): bool
    {
        return AccessibleInterface::ACCESS_PUBLIC === $this->accessType;
    }

    /**
     * Уровень доступа - защищенный
     * @return bool
     */
    public function isProtected(): bool
    {
        return AccessibleInterface::ACCESS_PROTECTED === $this->accessType;
    }

    /**
     * Уровень доступа закрытый
     * @return bool
     */
    public function isPrivate(): bool
    {
        return AccessibleInterface::ACCESS_PRIVATE === $this->accessType;
    }
}
