<?php

namespace Hyperreal\AcaciaBundle\Internals\Security;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("METHOD")
 */
class OwnerOnly
{

}