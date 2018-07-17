<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lsdg_post")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\PostRepository")
 */
class Post
{
  /**
  * @var int
   * @ORM\Id
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
  * @var string
  * @ORM\Column(name="content", type="text")
  **/

  private $content;

  /**
  * @var \DateTime
  *
  *@ORM\Column(name="date", type="datetime")
  */

  private $date;

  /**
   * @var ArrayCollection
   * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Thread", inversedBy="post")
   * @ORM\JoinColumn(nullable=false)
   */
  private $thread;

  /**
  * @var int
  *
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User", inversedBy="post")
   * @ORM\JoinColumn(nullable=false)
   */
  private $user;

  public function __construct()
  {
    $this->date         = new \Datetime();
  }
  /**
  * @param \DateTime $date
  */
  public function setDate($date)
  {
    $this->date = $date;
  }

  /**
  * @return \DateTime
  */
  public function getDate()
  {
    return $this->date;
  }


  public function getId()
  {
    return $this->id;
  }

  /**
    * @param string $content
    *
    * @return Post
    */
   public function setContent($content)
   {
       $this->content = $content;
       return $this;
   }
   /**
    * @return string
    */
   public function getContent()
   {
       return $this->content;
   }


  /**
     * @param Thread $thread
     *
     * @return Post
     */
    public function setThread(Thread $thread)
    {
        $this->thread = $thread;
        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getThread()
    {
        return $this->thread;
    }


    /**
    * @param User $user
    */
    public function setUser($user)
    {
      $this->user = $user;
    }

    /**
    * @return  User $user
    */

    public function getUser()
    {
      return $this->user;
    }


  public function __toString()
  {
    return $this->content;
  }
}
