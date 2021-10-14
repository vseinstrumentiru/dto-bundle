<?php

declare(strict_types=1);

namespace Vseinstrumentiru\DataObjectBundle\Resolver;

use Vseinstrumentiru\DataObjectBundle\Exception\ObjectInitError;
use Vseinstrumentiru\DataObjectBundle\ObjectFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestObjectResolver implements ArgumentValueResolverInterface
{
    /**
     * Dto initializer
     */
    private ObjectFactoryInterface $objectFactory;

    public function __construct(ObjectFactoryInterface $objectFactory)
    {
        $this->objectFactory = $objectFactory;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if ($argument->getType() === null) {
            return false;
        }

        if (!$this->objectFactory->supportsDataObjectClass($argument->getType())) {
            return false;
        }

        return true;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        if (!$this->supports($request, $argument)) {
            yield null;
        }

        if ($request->isMethod('GET')) {
            $requestData = $request->query->all();
        } else {
            $requestData = $request->request->all();
        }

        try {
            yield $this->objectFactory->createDataObject($requestData, $argument->getType());
        } catch (ObjectInitError $e) {
            throw new BadRequestHttpException('Invalid request is passed', $e, $e->getCode());
        }
    }
}
