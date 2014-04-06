<?php

namespace Hyperreal\AcaciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order 
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(inversedBy="orders", targetEntity="Order")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Announcement", inversedBy="orders")
     * @ORM\JoinColumn(name="announcement_id", referencedColumnName="id", nullable=false)
     */
    private $announcement;

    public function getId()
    {
        return $this->id;
    }


} 