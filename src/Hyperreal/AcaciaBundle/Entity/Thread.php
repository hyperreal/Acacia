<?php

namespace Hyperreal\AcaciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * Announcement discussion container
 *
 * @ORM\Entity
 * @ORM\Table(name="threads")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread
{
    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var Announcement
     *
     * @ORM\OneToOne(targetEntity="Announcement", inversedBy="thread")
     * @ORM\JoinColumn(name="announcement_id", referencedColumnName="id")
     */
    protected $announcement;

    /**
     * @return Announcement
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }

    public function setAnnouncement(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }
}