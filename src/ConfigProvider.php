<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

class ConfigProvider
{
    public function getCliConfig(): array
    {
        return [
            'commands' => [
                'thememanager:build-theme' => Command\BuildTheme::class,
            ],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'aliases'   => [
                'ViewTemplatePathStack' => View\Resolver\TemplatePathStack::class,
            ],
            'factories' => [
                Command\BuildTheme::class          => Command\BuildThemeFactory::class,
                Listener\AdminLayoutListener::class    => Listener\AdminLayoutListenerFactory::class,
                View\Resolver\TemplatePathStack::class => ViewTemplatePathStackFactory::class,
            ],
            'delegators' => [
                'ViewTemplateMapResolver' => [
                    View\Resolver\TemplateMapFactory::class,
                ],
                View\Resolver\TemplatePathStack::class => [
                    View\Resolver\TemplatePathStackFactory::class
                ],
            ],
        ];
    }

    public function getListenerConfig(): array
    {
        return [
            Listener\AdminLayoutListener::class,
        ];
    }

    public function getViewManagerConfig(): array
    {
        return [
            'admin_template' => 'layout/admin',
        ];
    }
}
