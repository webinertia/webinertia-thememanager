<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Model;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Webinertia\ThemeManager\Session\Container;

class ThemeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Theme
    {
        return new $requestedName(
            $container->get('config')['theme_manager'],
            $container->has(Container::class) ? $container->get(Container::class) : null
        );
    }
}
