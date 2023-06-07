<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Form;

use Laminas\ServiceManager;
use Psr\Container\ContainerInterface;
use Webinertia\ThemeManager\Model\Theme;

final class ThemeChangerFactory implements ServiceManager\Factory\FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ThemeChanger
    {
        if (! $container->has(Theme::class)) {
            throw new ServiceManager\Exception\ServiceNotFoundException(
                Theme::class . ' service not found. Are you sure you provided it during configuration?'
            );
        }
        return new $requestedName(null, null, $container->get(Theme::class));
    }
}
