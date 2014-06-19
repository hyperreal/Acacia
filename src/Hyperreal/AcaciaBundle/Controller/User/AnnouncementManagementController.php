<?php

namespace Hyperreal\AcaciaBundle\Controller\User;

use Hyperreal\AcaciaBundle\Controller\AcaciaController;
use Hyperreal\AcaciaBundle\Entity\Announcement;
use Hyperreal\AcaciaBundle\Form\AddAnnouncementFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementManagementController extends AcaciaController
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
            ->getUserAnnouncements($user, 0, 20);

        return array(
            'announcements' => $announcements
        );
    }

    /**
     * @Route("/new", name="acacia_user_announcement_management_new")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm($this->get('acacia.form.add_announcement'), new Announcement());

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

            $this->get('session')->getFlashBag()->add('success', $this->trans('announcement.management.add.success'));

            return new RedirectResponse($this->generateUrl('acacia_user_announcement_management_index'));
        }

        $this->get('session')->getFlashBag()->add('notice', $this->trans('announcement.management.add.errors'));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{announcement}", name="acacia_user_announcement_management_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function editAction(Announcement $announcement)
    {
        $form = $this->createForm(new AddAnnouncementFormType(), $announcement);

        return array(
            'announcement' => $announcement,
            'form' => $form->createView(),
        );
    }
}