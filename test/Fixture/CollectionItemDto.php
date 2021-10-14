<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Fixture;

use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;

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
