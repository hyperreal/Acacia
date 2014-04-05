<?php

namespace Hyperreal\DmtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AnnouncementController extends Controller
{
    /**
     * @Route("/", name="hyperreal_dmt_announcements")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

    }
}
