<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Command;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class BuildThemeFactory implements FactoryInterface
{
    /** @param string $requestedName */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): BuildTheme
    {
        return new $requestedName($container->get('config'));
    }
}
