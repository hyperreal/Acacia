<?php

namespace Hyperreal\AcaciaBundle\Listing;

use Doctrine\ORM\EntityManager;
use Hyperreal\AcaciaBundle\Entity\Announcement;

class AnnouncementDoctrineFacade implements ListingFacade
{
    /** @var \Doctrine\ORM\EntityManager */
    private $entityManager;
    private $announcementsPerPage;

    function __construct(EntityManager $entityManager, $announcementsPerPage)
    {
        $this->entityManager = $entityManager;
        $this->announcementsPerPage = $announcementsPerPage;
    }

    public function getAnnouncementsForListing($pageNum)
    {
        return array(
            new Announcement(),
            new Announcement()
        );
    }
}