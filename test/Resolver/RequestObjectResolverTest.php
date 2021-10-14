<?php

declare(strict_types=1);

namespace Test\Vseinstrumentiru\DataObjectBundle\Resolver;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vseinstrumentiru\DataObjectBundle\Exception\ObjectInitError;
use Vseinstrumentiru\DataObjectBundle\ObjectFactory;
use Vseinstrumentiru\DataObjectBundle\Resolver\RequestObjectResolver;
use Test\Vseinstrumentiru\DataObjectBundle\Fixture\SomeDto;

class RequestObjectResolverTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ArgumentResolver
     */
    private $argumentsResolver;

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
                    'order' => 321.00,
                ]
            ],
        ];
        $controller = function (SomeDto $someArgument) {};

        $this->request->request->add($data);

        $arguments = $this->argumentsResolver->getArguments($this->request, $controller);
        $this->assertCount(1, $arguments);

        $this->assertEquals(new SomeDto($data), $arguments[0]);
    }
}
