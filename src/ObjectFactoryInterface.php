<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle;

use ViTech\DataObjectBundle\Exception\ObjectInitError;

interface ObjectFactoryInterface
{
    /**
     * Создает объект данных на основании переданных данных и указанного класса объекта
     *
     * @param array  $data
     * @param string $objectClass Class<T>
     *
     * @return object Object<T>
     *
     * @throws ObjectInitError
     */
    public function createDataObject(array $data, string $objectClass): object;

    /**
     * Проверяет поддержку фабрикой указанного класса
     *
     * @param string $dataObjectClass
     *
     * @return bool
     */
    public function supportsDataObjectClass(string $dataObjectClass): bool;
}
