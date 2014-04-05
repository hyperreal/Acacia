<?php

namespace Hyperreal\DmtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Hyperreal\DmtBundle\Entity\Repository\AnnouncementRepository")
 * @ORM\Table(name="announcements")
 */
class Announcement
{
    const TYPE_PREMIUM = 1;
    const TYPE_STANDARD = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="announcements")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var \Hyperreal\DmtBundle\Entity\User
     */
    private $user;

    /**
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @ORM\Column(name="last_modification_date", type="datetime")
     * @var \DateTime
     */
    private $lastModificationDate;

    /**
     * @ORM\Column(name="payment_status", type="integer")
     */
    private $paymentStatus;

    /**
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     *
     * one to many with comment
     */
    private $comments;

    /**
     * one to many with payments
     */
    private $payments;

    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getLastModificationDate()
    {
        return $this->lastModificationDate;
    }

    public function setLastModificationDate(\DateTime $lastModificationDate)
    {
        $this->lastModificationDate = $lastModificationDate;
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}