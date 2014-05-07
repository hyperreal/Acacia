<?php

namespace Hyperreal\AcaciaBundle\Internals\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Yaml\Parser;

class RoleBasedControllerSetterEventSubscriber implements EventSubscriberInterface
{
    private $configurationMap;

    private $configuration;

    /** @var \Symfony\Component\Security\Core\SecurityContextInterface */
    private $securityContext;

    /** @var \Symfony\Component\HttpKernel\Controller\ControllerResolverInterface */
    private $controllerResolver;

    public function __construct(
        $configurationMap,
        SecurityContextInterface $securityContext,
        ControllerResolverInterface $controllerResolver
    ) {
        $this->configurationMap = __DIR__ . '/../../../../../' . $configurationMap;
        $this->configuration = $this->getConfiguration();
        $this->securityContext = $securityContext;
        $this->controllerResolver = $controllerResolver;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'setControllerInRequest',
            KernelEvents::CONTROLLER => 'selectController'
        );
    }

    public function setControllerInRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->get('_route');

        if (false !== ($role = $this->shouldOverrideController($event->getRequest()))) {
            $event->getRequest()->attributes->set('_controller', $this->configuration[$route][$role]);
        }
    }

    public function selectController(FilterControllerEvent $event)
    {
        if (false !== $this->shouldOverrideController($event->getRequest())) {
            $event->setController($this->controllerResolver->getController($event->getRequest()));
        }
    }

    private function shouldOverrideController(Request $request)
    {
        $route = $request->get('_route');

        if (!array_key_exists($route, $this->configuration)) {
            return false;
        }

        foreach ($this->configuration[$route] as $role => $controller) {
            if ($this->securityContext->isGranted($role)) {
                return $role;
            }
        }

        return false;
    }

    private function getConfiguration()
    {
        $parser = new Parser();
        return $parser->parse(file_get_contents($this->configurationMap));
    }
}