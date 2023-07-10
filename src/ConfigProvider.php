<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\View\Helper\Asset;

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
            'factories' => [
                Command\BuildTheme::class              => Command\BuildThemeFactory::class,
                Listener\AdminLayoutListener::class    => Listener\AdminLayoutListenerFactory::class,
                Model\Theme::class                     => Model\ThemeFactory::class,
                View\Resolver\TemplatePathStack::class => ViewTemplatePathStackFactory::class,
                'ViewTemplatePathStack'                => View\Resolver\TemplatePathStackFactory::class,
            ],
            'delegators' => [
                'ViewTemplateMapResolver' => [
                    View\Resolver\TemplateMapFactory::class,
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
            'admin_template' => null,
            'template_path_stack' => [
                __DIR__ . '/../view',
            ],
            'strategies'          => [
                'ViewJsonStrategy',
            ],
        ];
    }

    public function getThemeManagerConfig(): array
    {
        return [
            'theme_changer_session_length' => 3600 * 24 * 365 * 5, // this is set a LONG way out so the theme doesnt reset ;)
        ];
    }

    public function getFormElementConfig(): array
    {
        return [
            'factories' => [
                Form\Login::class => InvokableFactory::class,
            ],
        ];
    }

    public function getViewHelperConfig(): array
    {
        return [
            'factories' => [
                Asset::class => View\Helper\Service\AssetFactory::class,
            ],
        ];
    }
}
