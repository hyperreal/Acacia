<?php

namespace Hyperreal\AcaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        }
    }

    /**
     * @Template()
     * @Method("GET")
     */
    public function indexLoggedInAction()
    {
        return array('name' => 'dupa');
    }
}
