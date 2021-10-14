<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Resolver;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Test\Vseinstrumentiru\DataObjectBundle\Fixture\CollectionItemDto;
use Vseinstrumentiru\DataObjectBundle\Exception\ObjectInitError;
use Vseinstrumentiru\DataObjectBundle\ObjectFactory;
use Vseinstrumentiru\DataObjectBundle\Resolver\RequestObjectResolver;
use Test\Vseinstrumentiru\DataObjectBundle\Fixture\SomeDto;

class RequestObjectResolverTest extends TestCase
{
    private Request $request;

    private ArgumentResolver $argumentsResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request           = new Request();
        $requestObjectResolver   = new RequestObjectResolver(new ObjectFactory());
        $this->argumentsResolver = new ArgumentResolver(null, [$requestObjectResolver]);
    }

    public function testUnsupportedArgumentResolve(): void
    {
        $controller = function (\stdClass $someArgument) {};

        $this->expectException(\RuntimeException::class);

        $this->argumentsResolver->getArguments($this->request, $controller);
    }

    public function testInvalidRequestResolve(): void
    {
        $controller = function (SomeDto $someArgument) {};

        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage("Invalid request is passed");
        $this->expectExceptionCode(ObjectInitError::CODE_GENERAL_INIT_ERROR);

        $this->argumentsResolver->getArguments($this->request, $controller);
    }

    public function testArgumentResolve(): void
    {
        $data = [
            'someProperty' => 'some value',
            'someEmbeddedProperty' => [
                'property1' => 123,
                'property2' => 'sub value property 2'
            ],
            'collectionItems' => [
                [
                    'name' => 'some name',
                    'order' => 321.09,
                ],
                [
                    'name' => 'Another name',
                    'order' => -123.45,
                ],
            ],
        ];
        $controller = function (SomeDto $someArgument) {};

        $this->request->request->add($data);

        $arguments = $this->argumentsResolver->getArguments($this->request, $controller);
        self::assertCount(1, $arguments);

        /** @var SomeDto $resolved */
        $resolved = $arguments[0];
        self::assertInstanceOf(SomeDto::class, $resolved);
        self::assertEquals(new SomeDto($data), $resolved);

        self::assertEquals($data['someProperty'], $resolved->someProperty);
        self::assertEquals($data['someEmbeddedProperty']['property1'], $resolved->someEmbeddedProperty->property1);
        self::assertEquals($data['someEmbeddedProperty']['property2'], $resolved->someEmbeddedProperty->property2);
        self::assertContainsOnlyInstancesOf(CollectionItemDto::class, $resolved->collectionItems);
        self::assertCount(2, $resolved->collectionItems);
        self::assertEquals($data['collectionItems'][0]['name'], $resolved->collectionItems[0]->name);
        self::assertSame($data['collectionItems'][0]['order'], $resolved->collectionItems[0]->order);
        self::assertEquals($data['collectionItems'][1]['name'], $resolved->collectionItems[1]->name);
        self::assertSame($data['collectionItems'][1]['order'], $resolved->collectionItems[1]->order);
    }
}
