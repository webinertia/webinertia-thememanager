<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\View\Resolver;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Laminas\View\Resolver\TemplateMapResolver;
use Psr\Container\ContainerInterface;

class TemplateMapFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): TemplateMapResolver
    {
        $stack = \call_user_func($callback, []);
        $stack->setMap([]);
        return $stack;
    }
}
