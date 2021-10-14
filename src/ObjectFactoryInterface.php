<?php

declare(strict_types=1);

namespace Vseinstrumentiru\DataObjectBundle;

use Vseinstrumentiru\DataObjectBundle\Exception\ObjectInitError;

interface ObjectFactoryInterface
{
    /**
     * Creates DTO based on passed data and class name
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
     * Determines whether an object creation from class is supported by the factory
     *
     * @param string $dataObjectClass
     *
     * @return bool
     */
    public function supportsDataObjectClass(string $dataObjectClass): bool;
}
