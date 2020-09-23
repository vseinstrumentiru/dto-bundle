<?php

declare(strict_types=1);

namespace Test\ViTech\DataObjectBundle\Fixture;

use ViTech\DataObjectBundle\Object\AbstractObject;

class SomeSubDto extends AbstractObject
{
    /**
     * @var int
     */
    public $property1;

    /**
     * @var string
     */
    public $property2;
}
