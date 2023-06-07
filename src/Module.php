<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager;

final class Module
{
    public function getConfig(): array
    {
        $configProvider = new ConfigProvider();
        return [
            'laminas-cli'        => $configProvider->getCliConfig(),
            'service_manager'    => $configProvider->getDependencyConfig(),
            'listeners'          => $configProvider->getListenerConfig(),
            'view_manager'       => $configProvider->getViewManagerConfig(),
            'session_config'     => $configProvider->getSessionConfig(),
            'session_containers' => $configProvider->getSessionContainerConfig(),
            'session_storage'    => $configProvider->getSessionStorageConfig(),
            'session_validators' => $configProvider->getSessionValidatorConfig(),
            'theme_manager'      => $configProvider->getThemeManagerConfig(),
            'controllers'        => $configProvider->getControllerConfig(),
            'router'             => $configProvider->getRouteConfig(),
            'form_elements'      => $configProvider->getFormElementConfig(),
            'validators'         => $configProvider->getValidatorConfig(),
        ];
    }
}
