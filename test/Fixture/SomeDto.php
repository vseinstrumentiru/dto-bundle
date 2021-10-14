<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Fixture;

use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;

class SomeDto extends AbstractObject
{
    public string $someProperty;

    public SomeSubDto $someEmbeddedProperty;

    /**
     * Fully qualified namespace is required by spatie/dto.
     * @var \Test\Vseinstrumentiru\DataObjectBundle\Fixture\CollectionItemDto[]
     */
    public array $collectionItems;
}
