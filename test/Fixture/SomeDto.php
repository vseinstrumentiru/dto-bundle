<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Fixture;

use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;

class SomeDto extends AbstractObject
{
    /**
     * @var string
     */
    public $someProperty;

    /**
     * Fully qualified namespace is required by spatie/dto
     * @var \Test\Vseinstrumentiru\DataObjectBundle\Fixture\SomeSubDto
     */
    public $someEmbeddedProperty;

    /**
     * @var \Test\Vseinstrumentiru\DataObjectBundle\Fixture\CollectionItemDto[]
     */
    public $collectionItems;
}
