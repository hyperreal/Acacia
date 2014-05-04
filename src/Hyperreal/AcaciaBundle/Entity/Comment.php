<?php

namespace Hyperreal\AcaciaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;

/**
 * Announcement discussion entry
 *
 * @ORM\Entity()
 * @ORM\Table(name="comments")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Comment extends BaseComment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Hyperreal\AcaciaBundle\Entity\Thread")
     */
    protected $thread;
} 