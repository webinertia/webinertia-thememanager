<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Listener;

use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Resolver\TemplateMapResolver;
use Psr\Container\ContainerInterface;

class AdminLayoutListenerFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AdminLayoutListener
    {
        return new $requestedName(
            $container->get(ControllerManager::class),
            $container->get(TemplateMapResolver::class),
            $container->get('config')['view_manager']
        );
    }
}
