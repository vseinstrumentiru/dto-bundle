<?php

declare(strict_types=1);

namespace Vseinstrumentiru\DataObjectBundle\Object;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Abstract data object
 *
 * This class encapsulates spatie/data-transfer-object to leave space for further replacement.
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
