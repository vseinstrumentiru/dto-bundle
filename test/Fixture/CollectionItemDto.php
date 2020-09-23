<?php

declare(strict_types=1);

namespace Test\ViTech\DataObjectBundle\Fixture;

use ViTech\DataObjectBundle\Object\AbstractObject;

class CollectionItemDto extends AbstractObject
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $order;
}
