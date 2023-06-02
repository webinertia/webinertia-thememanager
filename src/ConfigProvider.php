<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Session;
use Webinertia\ThemeManager\Session\Container;
use Webinertia\ThemeManager\Session\ContainerFactory;

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
                Command\BuildTheme::class              => Command\BuildThemeFactory::class,
                Container::class                       => ContainerFactory::class,
                Listener\AdminLayoutListener::class    => Listener\AdminLayoutListenerFactory::class,
                Listener\ThemeChanger::class           => Listener\ThemeChangerFactory::class,
                Model\Theme::class                     => InvokableFactory::class,
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
            Listener\ThemeChanger::class,
        ];
    }

    public function getViewManagerConfig(): array
    {
        return [
            'admin_template' => 'layout/admin',
        ];
    }

    public function getSessionConfig(): array
    {
        return [
            'use_cookies' => true,
        ];
    }

    public function getSessionContainerConfig(): array
    {
        return [Session\Container::class];
    }

    public function getSessionStorageConfig(): array
    {
        return [
            'type' => Session\Storage\SessionArrayStorage::class,
        ];
    }

    public function getSessionValidatorConfig(): array
    {
        return [
            Session\Validator\RemoteAddr::class,
            Session\Validator\HttpUserAgent::class,
        ];
    }

    public function getThemeManagerConfig(): array
    {
        return [
            'theme_changer_session_length' => 3600 * 24 * 365 * 5,
        ];
    }
}
