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
    /**
     * Указание игнорировать параметры, которых нет в dto
     *
     * @var bool
     */
    protected $ignoreMissing = true;

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
