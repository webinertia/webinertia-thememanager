<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\View\Helper\Service;

use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;
use Webinertia\ThemeManager\Model\Theme;
use Webinertia\ThemeManager\View\Helper\Asset;

final class AssetDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): Asset
    {
        if (! $container->has(Theme::class)) {
            throw new ServiceNotFoundException(
                'Service: ' . Theme::class . ' not found in container are you sure you provided it during config?'
            );
        }
        $theme = $container->get(Theme::class);
        $assetHelper = new Asset($theme->getResourceMap());
        //$assetHelper->setView($container->get('ViewRenderer'));
        return $assetHelper;
    }
}
