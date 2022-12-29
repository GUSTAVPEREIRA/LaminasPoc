<?php

namespace App\Configs;

use App\Middleware\Bar;
use App\Middleware\Foo;
use App\Middleware\Home;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Stratigility\MiddlewarePipe;
use Poc\MiddlewarePipeFactory;
use Poc\RequestHandlerRunnerFactory;

class DependencyInjection
{
    private RequestHandlerRunner $requestHandlerRunner;

    public function __construct()
    {
        $serviceManager = new ServiceManager([
            'factories' => [
                MiddlewarePipe::class => MiddlewarePipeFactory::class,
                RequestHandlerRunner::class => RequestHandlerRunnerFactory::class,
                Home::class => InvokableFactory::class,
                Foo::class => InvokableFactory::class,
                Bar::class => InvokableFactory::class
            ],
        ]);

        $this->requestHandlerRunner = $serviceManager->get(RequestHandlerRunner::class);
    }

    public function execute()
    {
        $this->requestHandlerRunner->run();
    }
}
