<?php

namespace Hyperreal\AcaciaBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Hyperreal\AcaciaBundle\Entity\User;

class AnnouncementRepository extends EntityRepository
{
    public function getAnnouncementsForListing($offset, $limit)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->from('HyperrealAcaciaBundle:Announcement', 'a')
            ->addOrderBy('type', 'desc')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();
    }

    public function getUserAnnouncements(User $user)
    {
        return array();
    }
} 