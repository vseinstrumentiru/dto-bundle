<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Fixture;

use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;

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
