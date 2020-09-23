# DTO Bundle
Package for an automatic request to predefined structures conversion in symfony applications.  

[![Build Status](https://travis-ci.org/vseinstrumentiru/dto-bundle.svg?branch=master)](https://travis-ci.org/github/vseinstrumentiru/dto-bundle)
[![Coverage Status](https://coveralls.io/repos/github/vseinstrumentiru/dto-bundle/badge.svg?branch=master)](https://coveralls.io/github/vseinstrumentiru/dto-bundle?branch=master)

## Installation

```bash
$ composer require vi-tech/dto-bundle
```

Declare bundle in configuration:

```php
// config/bundles.php
return [
    \ViTech\DataObjectBundle\DataObjectBundle::class => ['all' => true],
];
```

## Usage

```php
<?php

use Symfony\Component\HttpFoundation\Response;
use ViTech\DataObjectBundle\Object\AbstractObject;

class RegistrationDto extends AbstractObject
{
    /** @var string */
    public $login;
    
    /** @var string */
    public $password;
}

class RegistrationController
{
    public function __invoke(RegistrationDto $registration): Response
    {
        // Register new user using $registration
        // $registration->login contains Request::$request->get('login'). Same for password.

        return new Response();
    }
}

```

Data in `RegistrationDto $registration` matches Request::$request properties.  
If request contains properties that are not declared in DTO they will be omitted.  
On property type mismatch `Symfony\Component\HttpKernel\Exception\BadRequestHttpException` will be thrown.  

It is a common approach to validate DTO within application.  
The simplest way to do that is to declare *constraints* annotations for the same DTO and use *[symfony validator](https://symfony.com/doc/current/components/validator.html)*.


```php
<?php

use Symfony\Component\HttpFoundation\Response;
use ViTech\DataObjectBundle\Object\AbstractObject;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationDto extends AbstractObject
{
    /**
     * @Assert\NotBlank()
     * @Assert\UniqueLogin()
     *
     * @var string
     */
    public $login;
    
    /**
     * @Assert\NotBlank()
     * @Assert\PasswordRules()
     *
     * @var string
     */
    public $password;
}

class RegistrationController
{
    /** @var ValidatorInterface */
    private $validator;

    public function __invoke(RegistrationDto $registration): Response
    {
        $violations = $this->validator->validate($registration);
        if (count($violations)) {
            // Handle constraints violations
        }

        // register new user using $registration

        return new Response();
    }
}

```
