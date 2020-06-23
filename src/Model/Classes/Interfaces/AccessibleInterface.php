<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Интерфейс доступности (области видимости)
 * Interface AccessibleInterface
 */
interface AccessibleInterface
{
    /**
     * Публичный доступ (public)
     */
    public const ACCESS_PUBLIC = 0;

    /**
     * Защищенный доступ (protected)
     */
    public const ACCESS_PROTECTED = 1;

    /**
     * Закрытый доступ (private)
     */
    public const ACCESS_PRIVATE = 2;

    /**
     * Список возможных типов доступа
     */
    public const ACCESS_LIST = [
        self::ACCESS_PUBLIC,
        self::ACCESS_PROTECTED,
        self::ACCESS_PRIVATE
    ];

    /**
     * Возвращает уровень доступа в виде числа self::ACCESS_PUBLIC | self::ACCESS_PROTECTED | self::ACCESS_PRIVATE
     *
     * @return int
     */
    public function getAccessType(): int;

    /**
     * Уровень доступа - публичный
     *
     * @return bool
     */
    public function isPublic(): bool;

    /**
     * Уровень доступа - защищенный
     *
     * @return bool
     */
    public function isProtected(): bool;

    /**
     * Уровень доступа закрытый
     *
     * @return bool
     */
    public function isPrivate(): bool;
}
