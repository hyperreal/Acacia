<?php

namespace Hyperreal\AcaciaBundle;

use Hyperreal\AcaciaBundle\DependencyInjection\AcaciaExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HyperrealAcaciaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->registerExtension(new AcaciaExtension());
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
