<?php

namespace Hyperreal\AcaciaBundle\Controller\User;

use Hyperreal\AcaciaBundle\Entity\Announcement;
use Hyperreal\AcaciaBundle\Form\AddAnnouncementFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementManagementController extends Controller
{
    /**
     * @Route("/", name="acacia_user_announcement_management_index")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
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
     * @Route("/add", name="acacia_user_announcement_management_new")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new AddAnnouncementFormType(), new Announcement());

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/save", name="acacia_user_announcement_management_save")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     * @Template("HyperrealAcaciaBundle:User:AnnouncementManagement/new.html.twig")
     */
    public function saveAction(Request $request)
    {
        $announcement = new Announcement();
        $announcement->setUser($this->getUser());
        $form = $this->createForm(new AddAnnouncementFormType(), $announcement);
        $form->submit($request);

        if ($form->isValid()) {
            $this->get('doctrine.orm.entity_manager')->persist($announcement);
            $this->get('doctrine.orm.entity_manager')->flush();

            $this->get('session')->getFlashBag()->add('costam', 'jest ok');
            return new RedirectResponse($this->generateUrl('acacia_user_announcement_management_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }


}