<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

return [
    'listeners' => [
        Listener\AdminLayoutListener::class,
    ],
    'service_manager' => [
        'aliases' => [
            'ViewTemplatePathStack'   => View\Resolver\TemplatePathStack::class,
        ],
        'factories' => [
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
    ],
    'view_manager' => [
        'admin_template' => 'layout/admin',
    ],
];