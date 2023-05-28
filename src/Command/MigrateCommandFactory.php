<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Command;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class MoveCommandFactory implements FactoryInterface
{
    /** @param string $requestedName */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): MigrateCommand
    {
        return new $requestedName($container->get(AdapterInterface::class), $container->get('config'));
    }
}
