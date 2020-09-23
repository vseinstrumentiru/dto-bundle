<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle\Object;

/**
 * Data object interface
 *
 * Determines if DTO has relation with this module to avoid excess resolving.
 */
interface DataObjectInterface
{
    /**
     * Checks if an object is the data object
     *
     * This method exists to clarify intentions of this interface.
     * It does not really have to anything useful.
     *
     * @internal
     *
     * @return bool
     */
    public function isDataObject(): bool;
}
