<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle\Object;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Абстрактный класс объекта данных.
 *
 * Является инкапсуляцией spatie/data-transfer-object для возможности замены на что-то другое.
 */
abstract class AbstractObject extends DataTransferObject implements DataObjectInterface
{
    public function __construct(array $parameters = [])
    {
        $this->ignoreMissing = true;

        parent::__construct($parameters);
    }

    /**
     * @internal
     *
     * @return bool
     */
    final public function isDataObject(): bool
    {
        return true;
    }
}
