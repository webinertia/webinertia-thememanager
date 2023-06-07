<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Listener;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;

final class ThemeChanger extends AbstractListenerAggregate
{
    public function __construct(
        protected Container $themeData
    ) {
    }

    /** @inheritDoc */
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'changeTheme']);
    }

    public function changeTheme(MvcEvent $event): void
    {
        /** @var Request \Laminas\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();
        $params   = $request->getQuery()->toArray();
        if (
            ! (isset($params['context']) && $params['context'] === 'ThemeChanger')
            || ! isset($params['selected'])
        ) {
            return;
        }
        $this->themeData->theme = $params['selected'];
    }
}
