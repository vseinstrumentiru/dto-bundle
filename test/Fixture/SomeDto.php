<?php

declare(strict_types=1);

namespace Test\ViTech\DataObjectBundle\Fixture;

use ViTech\DataObjectBundle\Object\AbstractObject;

class SomeDto extends AbstractObject
{
    /**
     * @var string
     */
    public $someProperty;

    /**
     * Fully qualified namespace is required by spatie/dto
     * @var \Test\ViTech\DataObjectBundle\Fixture\SomeSubDto
     */
    public $someEmbeddedProperty;

    /**
     * @var \Test\ViTech\DataObjectBundle\Fixture\CollectionItemDto[]
     */
    public $collectionItems;
}
