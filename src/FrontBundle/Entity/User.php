<?php

namespace FrontBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
    * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;


    /**
    *
    *@var int
    * @ORM\OneToMany(targetEntity="FrontBundle\Entity\Comment", mappedBy="user", cascade={"persist", "remove"})
    */
    private $comments;


    /**
    *
    *@var ArrayCollection
    * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Thread", mappedBy="user", cascade={"persist", "remove"})
    */
    private $thread;

    /**
    *
    *@var int
    * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Post", mappedBy="user", cascade={"persist", "remove"})
    */
    private $post;

    /**
    *
    * @var int
     * @ORM\Column(name="nbThread", type ="integer")
     */
    private $nbThread;

    /**
    *
    * @var int
     * @ORM\Column(name="nbPost", type ="integer")
     */
    private $nbPost;



    /**
    * @var string
    * @ORM\Column(name="signature", type="text")
    */
    private $signature;


    /**
    * @ORM\OneToOne(targetEntity="ForumBundle\Entity\Avatar", cascade={"persist", "remove"})
    */
    private $avatar;

    public function __construct()
    {
      $this->comments     = new ArrayCollection();
      $this->posts        = new ArrayCollection();
      $this->threads      = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getComment()
    {
      return $this->comments;
    }

    /**
     * @param Comment
     */
    public function addComment(Comment $comment)
    {
      $this->comments[] = $comment;

      return $this;
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
      $this->comments->removeElement($comment);
    }

    /**
    * @param int $nbThread
    *
    */
    public function getNbThread()
    {
      return $this->nbThread;
    }

    /**
    * @return int
    *
    */
    public function setNbThread($nbThread)
    {
      $this->nbThread = $nbThread;
    }

    /**
     * @param $nb
     *
     * @return $this
     */
    public function addNbThread($nb)
    {
        $this->nbThread += $nb;
        return $this;
    }


    /**
    * @param int $nbPost
    *
    */
    public function getNbPost()
    {
      return $this->nbPost;
    }

    /**
    * @return int
    *
    */
    public function setNbPost($nbPost)
    {
      $this->nbPost = $nbPost;
    }
    /**
     * @param $nb
     *
     * @return $this
     */
    public function addNbPost($nb)
    {
        $this->nbPost += $nb;
        return $this;
    }



    /**
     * @return ArrayCollection
     */
    public function getThread()
    {
      return $this->threads;
    }

    /**
     * @return ArrayCollection
     */
    public function getPost()
    {
      return $this->posts;
    }

}
