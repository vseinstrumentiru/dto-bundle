<?php

declare(strict_types=1);

namespace ViTech\DataObjectBundle\Resolver;

use ViTech\DataObjectBundle\Exception\ObjectInitError;
use ViTech\DataObjectBundle\ObjectFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestObjectResolver implements ArgumentValueResolverInterface
{
    /** @var ObjectFactoryInterface */
    private $objectFactory;

    public function __construct(ObjectFactoryInterface $objectFactory)
    {
        $this->objectFactory = $objectFactory;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if ($this->objectFactory->supportsDataObjectClass($argument->getType())) {
            return true;
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        if (!$this->supports($request, $argument)) {
            yield null;
        }

        $requestData = $request->request->all();

        try {
            yield $this->objectFactory->createDataObject($requestData, $argument->getType());
        } catch (ObjectInitError $e) {
            throw new BadRequestHttpException('Invalid request is passed', $e, $e->getCode());
        }
    }
}
