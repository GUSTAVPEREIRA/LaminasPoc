<?php

namespace Poc;

use Interop\Container\ContainerInterface;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Stratigility\MiddlewarePipe;

class RequestHandlerRunnerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $app = $container->get(MiddlewarePipe::class);

        return new RequestHandlerRunner(
            $app,
            new SapiEmitter(),
            static function () {
                return ServerRequestFactory::fromGlobals();
            },
            static function (\Exception $e) {
                $response = (new ResponseFactory())->createResponse(500);
                $response->getBody()->write(sprintf(
                    'An error occurred: %s',
                    $e->getMessage()
                ));
                return $response;
            }
        );
    }
}
