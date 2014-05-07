<?php

namespace Hyperreal\AcaciaBundle\Internals\Security;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\SecurityContextInterface;

class OwnerOnlyEventSubscriber implements EventSubscriberInterface
{
    /** @var \Symfony\Component\Security\Core\SecurityContextInterface */
    private $securityContext;

    /** @var \Doctrine\Common\Annotations\AnnotationReader */
    private $annotationReader;

    public function __construct(SecurityContextInterface $securityContext, AnnotationReader $annotationReader)
    {
        $this->securityContext = $securityContext;
        $this->annotationReader = $annotationReader;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'checkOwnership',
        );
    }

    public function checkOwnership(GetResponseEvent $event) // TODO: wrong event
    {
        // ReflectionMethod::__construct() accepts one argument, but IDEA doesn't know that.
        /** @noinspection PhpParamsInspection */
        $method = new \ReflectionMethod($event->getRequest()->get('_controller'));
        $annotation = $this->annotationReader->getMethodAnnotation($method, 'OwnerOnly');

        var_dump($annotation);
        die();





        return $this->securityContext->isGranted('a', null);
    }
}