<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\View\Helper\Service;

use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Laminas\View\Helper\BasePath;
use Psr\Container\ContainerInterface;
use Webinertia\ThemeManager\Model\Theme;

final class BasePathDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): BasePath
    {
        if (! $container->has(Theme::class)) {
            throw new ServiceNotFoundException('Service: ' . Theme::class . ' not found in container are you sure you provided it during config?');
        }
        /** @var Theme $theme */
        $theme = $container->get(Theme::class);
        $helper = new BasePath(Theme::BASE_PATH_SEGMENT . $theme->getActiveTheme());
        return $helper;
    }
}
