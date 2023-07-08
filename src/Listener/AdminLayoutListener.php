<?php

declare(strict_types=1);

namespace Webinertia\ThemeManager\Listener;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Resolver\TemplateMapResolver;
use Webinertia\Mvc\Controller\AdminControllerInterface;

use function sprintf;

final class AdminLayoutListener extends AbstractListenerAggregate
{
    /** @var array<mixed> $config */
    protected $config;
    /** @var AbstractAppController $controller */
    protected $controller;
    /** @var ControllerManager $controllerManager */
    protected $controllerManager;
    /** @var TemplateMapResolver */
    protected $templateMapResolver;
    /** @return void */
    public function __construct(
        ControllerManager $controllerManager,
        TemplateMapResolver $templateMapResolver,
        array $config
    ) {
        $this->config              = $config;
        $this->controllerManager   = $controllerManager;
        $this->templateMapResolver = $templateMapResolver;
    }

    /** @param int $priority */
    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, [$this, 'setAdminLayout']);
    }

    public function setAdminLayout(MvcEvent $event): void
    {
         // Get and check the route match object
        $routeMatch = $event->getRouteMatch();
        if (! $routeMatch) {
             return;
        }
         // Get and check the parameter for current controller
        $this->controller = $routeMatch->getParam('controller');
        $this->controller = $this->controllerManager->get($this->controller);
        // $name             = ;
        // if this is not an admin controller or if we have already got the layout return
        if (! ($this->templateMapResolver->has($this->config['admin_template']) || $this->controller instanceof AdminControllerInterface)) {
             return;
        }
        // Get root view model
        $layoutViewModel = $event->getViewModel();
        // Rendering without layout? This will be the case of all ajax requests
        if ($layoutViewModel->terminate()) {
            return;
        }
        // Change template
        $layoutViewModel->setTemplate($this->config['admin_template'] ?? $layoutViewModel->getTemplate());
    }
}
