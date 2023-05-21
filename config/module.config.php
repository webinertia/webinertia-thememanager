<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

return [
    'service_manager' => [
        'aliases' => [
            'ViewTemplatePathStack'   => View\Resolver\TemplatePathStack::class,
        ],
        'factories' => [
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
];