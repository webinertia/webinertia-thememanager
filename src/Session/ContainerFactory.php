<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Session;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Psr\Container\ContainerInterface;

class ContainerFactory implements FactoryInterface
{
    /** @param string $requestedName*/
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Container
    {
        /** 1 year fallback */
        $expiry = 3600 * 24 * 365;
        $config = $container->get('config');
        if (isset($config['theme_manager']['theme_changer_session_length'])) {
            $expiry = $config['theme_manager']['theme_changer_session_length'];
        }
        $sessionContainer = new $requestedName('ThemeData', $container->get(SessionManager::class));
        $sessionContainer->setExpirationSeconds($expiry);
        return $sessionContainer;
    }
}
