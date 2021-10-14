<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Fixture;

use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;

class SomeSubDto extends AbstractObject
{
    public int $property1;

    public string $property2;
}
