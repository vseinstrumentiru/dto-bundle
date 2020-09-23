<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle\Exception;

class ObjectInitError extends \Exception
{
    public const CODE_GENERAL_INIT_ERROR  = 1;
    public const CODE_NOT_SUPPORTED_CLASS = 2;
}
