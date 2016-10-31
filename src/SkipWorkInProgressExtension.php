<?php

namespace Brunty;

use Brunty\Runner\Maintainer\SkipWorkInProgressMaintainer;
use PhpSpec\Extension;
use PhpSpec\ServiceContainer;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

class SkipWorkInProgressExtension implements Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(ServiceContainer $container, array $params)
    {
        if ( ! $container instanceof IndexedServiceContainer) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The container from phpspec must implement the following: "%s"',
                    IndexedServiceContainer::class
                )
            );
        }

        $container->define(
            'runner.maintainers.skip_example',
            function (IndexedServiceContainer $c) {
                return new SkipWorkInProgressMaintainer();
            },
            ['runner.maintainers']
        );
    }
}
