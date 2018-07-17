<?php

namespace ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lsdg_thread")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ThreadRepository")
 */

class Thread
{
  /**
  * @var int
   * @ORM\Id
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;


  /**
  * @var bool
  * @ORM\Column(name="closed", type="boolean")
  */

  private $closed = 0;

  /**
  * @var Subforum
   * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Subforum", inversedBy="thread")
   * @ORM\JoinColumn(nullable=false)
   */
  private $subforum;

  /**
  * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Post", mappedBy="thread", cascade={"remove","persist"})
  */
  private $post;


  /**
  * @var string
  * @ORM\Column(name="title", type="string", length= 255)
  *
  */
  private $title;

  /**
  * @var int
  *
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User", inversedBy="thread")
   * @ORM\JoinColumn(nullable=false)
   */
  private $user;


  public function __construct()
  {
     $this->post = new ArrayCollection;
  }

  public function getId()
  {
    return $this->id;
  }

  /**
  * @return bool
  */
  public function getClosed()
  {
    return $this->closed;
  }

  /**
  * @return string
  */
  public function getTitle()
  {
    return $this->title;
  }

  /**
  * @param string $title
  */
  public function setTitle($title)
  {
    $this->title = $title;
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


  /**
 * Add category
 *
 * @param Subforum $subforum
 */
public function setSubforum(Subforum $subforum)
{
    $this->subforum = $subforum;

}

/**
* Add category
*
* @return Subforum $subforum
*/
public function getSubforum()
{
  return $this->subforum;

}

/**
   * @param $post
   *
   * @return Thread
   */
  public function setPost($post)
  {
      $this->post = $post;
      return $this;
  }
  /**
   * @return ArrayCollection
   */
  public function getPost()
  {
      return $this->post;
  }

  public function countPost()
  {
      return count($this->post);
  }
  /**
   * @param Post $post
   *
   * @return $this
   */
  public function addPost(Post $post)
  {
      $this->post->add($post);
      return $this;
  }
}
