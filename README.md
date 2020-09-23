# dto-bundle
Модуль для автоматического преобразования запросов в определенные структуры данных.


[![Build Status](https://travis-ci.org/vseinstrumentiru/dto-bundle.svg?branch=master)](https://travis-ci.org/github/vseinstrumentiru/dto-bundle)
[![Coverage Status](https://coveralls.io/repos/github/vseinstrumentiru/dto-bundle/badge.svg?branch=master)](https://coveralls.io/github/vseinstrumentiru/dto-bundle?branch=master)

## Установка

```bash
$ composer require vi-tech/dto-bundle
```

Подключить модуль в конфигурации проекта

```php
// config/bundles.php
return [
    \ViTech\DataObjectBundle\DataObjectBundle::class => ['all' => true],
];
```

## Использование

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
        // Действие над $registration

        return new Response();
    }
}

```

Данные в объекте `RegistrationDto $registration` соответствуют данным в Request::$request.
Если данные в запросе не соответствуют ожидаемым, запрос не дойдет до контроллера и выбросит HttpBadRequestException.  

Обычно DTO требуется валидировать правилами приложения.  
Такие проверки легче всего выполнить посредством аннотаций во все тех же DTO.  
Сама валидация должна проходить явно в контроллере.

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
            // Вернуть ответ со списком ошибок валидации
        }

        // Действие над $registration

        return new Response();
    }
}

```
