<?php

namespace Hyperreal\DmtBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as AbstractUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends AbstractUser
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Announcement", mappedBy="user")
     * @var ArrayCollection
     */
    private $announcements;

    /**
     * @ORM\Column(name="talk_id", type="integer", unique=true)
     */
    private $talkId;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     * @var ArrayCollection
     */
    private $orders;

    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection();
        $this->announcements = new ArrayCollection();
    }

    /**
     * @return Order
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection $orders
     */
    public function setOrders(ArrayCollection $orders)
    {
        $this->orders = $orders;
    }

    public function getTalkId()
    {
        return $this->talkId;
    }

    public function setTalkId($talkId)
    {
        $this->talkId = $talkId;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnnouncements()
    {
        return $this->announcements;
    }

    /**
     * @param ArrayCollection $announcements
     */
    public function setAnnouncements(ArrayCollection $announcements)
    {
        $this->announcements = $announcements;
    }
}