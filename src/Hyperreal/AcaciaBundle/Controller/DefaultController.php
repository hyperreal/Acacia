<?php

namespace Hyperreal\AcaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_welcome")
     * @Method("GET")
     */
    public function indexAction()
    {
        if ($this->getUser() == null) {
            return $this->render('HyperrealAcaciaBundle:Default:index.html.twig', array(
                'name' => "Acacia"
            ));
        } else {
            return $this->render('HyperrealAcaciaBundle:Default:indexLoggedIn.html.twig', array(
                'name' => 'Logged in Acacia',
            ));
        }
    }
}
