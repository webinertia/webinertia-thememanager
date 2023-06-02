<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Listener;

use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Webinertia\ThemeManager\Session\Container;

final class ThemeChangerFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! $container->has(Container::class)) {
            throw new ServiceNotFoundException('ThemeData Session container service was not found.');
        }
        return new $requestedName($container->get(Container::class));
    }
}
