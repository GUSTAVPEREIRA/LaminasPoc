<?php

namespace Poc;

use App\Middleware\Bar;
use App\Middleware\Foo;
use App\Middleware\Home;
use Laminas\Diactoros\Response;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;

use Interop\Container\ContainerInterface;

class MiddlewarePipeFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return MiddlewarePipe
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): MiddlewarePipe
    {
        $app = new MiddlewarePipe();
        $app->pipe($container->get(Home::class));
        $app->pipe($container->get(Foo::class));
        $app->pipe($container->get(Bar::class));

        $app->pipe(new NotFoundHandler(function () {
            return new Response();
        }));

        return $app;
    }
}
