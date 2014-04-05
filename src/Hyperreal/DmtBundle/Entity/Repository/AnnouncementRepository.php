<?php

namespace Hyperreal\DmtBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AnnouncementRepository extends EntityRepository
{
    private $announcementsPerPage;

    public function __construct($announcementsPerPage)
    {
        $this->announcementsPerPage = $announcementsPerPage;
    }

    public function getAnnouncementsForListing($pageNum)
    {

    }
} 