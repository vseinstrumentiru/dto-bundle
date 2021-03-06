<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle;

use Throwable;
use ViTech\DataObjectBundle\Exception\ObjectInitError;
use ViTech\DataObjectBundle\Object\AbstractObject;

class ObjectFactory implements ObjectFactoryInterface
{
    public function createDataObject(array $data, string $objectClass): object
    {
        if (!$this->supportsDataObjectClass($objectClass)) {
            throw new ObjectInitError('Unsupported data class', ObjectInitError::CODE_NOT_SUPPORTED_CLASS);
        }

        try {
            return new $objectClass($data);
        } catch (Throwable $e) {
            throw new ObjectInitError("Couldn't create object", ObjectInitError::CODE_GENERAL_INIT_ERROR, $e);
        }
    }

    public function supportsDataObjectClass(string $dataObjectClass): bool
    {
        if (is_subclass_of($dataObjectClass, AbstractObject::class)) {
            return true;
        }

        return false;
    }
}
