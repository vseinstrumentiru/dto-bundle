# DTO Bundle
Package for an automatic request to predefined structures conversion in symfony applications.  

[![Coverage Status](https://coveralls.io/repos/github/vseinstrumentiru/dto-bundle/badge.svg?branch=master)](https://coveralls.io/github/vseinstrumentiru/dto-bundle?branch=master)

## Installation

```bash
$ composer require vseinstrumentiru/dto-bundle
```

Declare bundle in configuration:

```php
// config/bundles.php
return [
    \Vseinstrumentiru\DataObjectBundle\DataObjectBundle::class => ['all' => true],
];
```

## Usage

Keep in mind that resolver matches only one strategy at a time and is fully dependent on  
Request::getMethod.  
**GET** Requests are mapped from query `Request->query->all()` .  
Every other method is mapped from request body `Request->request->all()`

> This means that one can not map data from body and query in the same request.  
> Normally there should not be such a situation.

```php
<?php

use Symfony\Component\HttpFoundation\Response;
use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;

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
use Vseinstrumentiru\DataObjectBundle\Object\AbstractObject;
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
