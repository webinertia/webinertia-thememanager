<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

use Laminas\Router\Http\Segment;
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
            'template_path_stack' => [
                __DIR__ . '/../view',
            ],
            'strategies'               => [
                'ViewJsonStrategy',
            ],
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

    public function getControllerConfig(): array
    {
        return [
            'factories' => [
                Controller\IndexController::class => Controller\IndexControllerFactory::class,
            ],
        ];
    }

    public function getRouteConfig(): array
    {
        return [
            'routes' => [
                'tm.login' => [
                    'type' => Segment::class,
                    'options' => [
                        'route'    => '/admin/thememanager[/:action]',
                        'defaults' => [
                            'controller' => Controller\IndexController::class,
                            'action'     => 'login',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getFormElementConfig(): array
    {
        return [
            'factories' => [
                Form\ThemeChanger::class => Form\ThemeChangerFactory::class,
                Form\Login::class        => InvokableFactory::class,
            ],
        ];
    }

    public function getValidatorConfig(): array
    {
        return [
            'factories' => [
                Validator\Password::class => InvokableFactory::class,
            ],
        ];
    }
}
