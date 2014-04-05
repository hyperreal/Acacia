<?php

namespace Hyperreal\DmtBundle\Listing;

use Doctrine\ORM\EntityManager;

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

    }
}