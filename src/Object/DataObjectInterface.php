<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle\Object;

/**
 * Интерфейс объекта данных
 *
 * Определяет связь внешнего класса ДТО с бандлом, чтобы резолвились только целевые объекты.
 */
interface DataObjectInterface
{
    /**
     * Проверяет, является ли класс объектом данных
     * Метод для явного уведомления о назначении AbstractObject.
     *
     * @internal
     *
     * @return bool
     */
    public function isDataObject(): bool;
}
