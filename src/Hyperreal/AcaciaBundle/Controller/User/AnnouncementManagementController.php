<?php

namespace Hyperreal\AcaciaBundle\Controller\User;

use Hyperreal\AcaciaBundle\Form\AddAnnouncementFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AnnouncementManagementController extends Controller
{
    /**
     * @Route("/", name="hyperreal_acacia_user_announcement_management_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var $user \Hyperreal\AcaciaBundle\Entity\User */
        $user = $this->getUser();

        $announcements = $this->get('doctrine.orm.entity_manager')
            ->getRepository('HyperrealAcaciaBundle:Announcement')
            ->getUserAnnouncements($user);

        return array(
            'announcements' => $announcements
        );
    }

    /**
     * @Route("/add", name="hyperreal_acacia_user_announcement_management_new")
     * @Method("GET")
     * @Template()
     */
    public function addAction()
    {
        $form = $this->createForm(new AddAnnouncementFormType());

        return array(
            'form' => $form->createView(),
        );
    }

} 