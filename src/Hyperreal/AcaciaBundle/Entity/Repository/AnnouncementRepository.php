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

    public function getUserAnnouncements(User $user, $offset, $limit)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('HyperrealAcaciaBundle:Announcement', 'a')
            ->where('a.user = ?1')
            ->orderBy('a.creationDate', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter(1, $user)
            ->getQuery();

        return $q->getResult();
    }
}