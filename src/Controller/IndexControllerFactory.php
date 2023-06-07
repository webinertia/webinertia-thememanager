<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

final class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): IndexController
    {
        return new $requestedName($container->get('FormElementManager'));
    }
}
