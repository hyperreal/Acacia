<?php

namespace Hyperreal\AcaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AnnouncementController extends Controller
{
    /**
     * @Route("/", name="hyperreal_acacia_announcement_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $this->get('hyperreal_acacia.listing.facade')->getAnnouncementsForListing(1);
    }
}
