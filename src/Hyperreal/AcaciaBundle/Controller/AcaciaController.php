<?php

namespace Hyperreal\AcaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AcaciaController extends Controller
{
    protected function trans($id, $parameters = array(), $domain = 'HyperrealAcaciaBundle')
    {
        return $this->get('translator')->trans($id, $parameters, $domain);
    }
}