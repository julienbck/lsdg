<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Table(name="comment")
* @ORM\Entity(repositoryClass="FrontBundle\Repository\CommentRepository")
*/

class Comment
{
  /**
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\Article", inversedBy="comments")
   * @ORM\JoinColumn(nullable=false)
   */
  private $article;

  /**
  * @var \DateTime
  *
  *@ORM\Column(name="date", type="datetime")
  */

  private $date;

  /**
  * @var int
  *
   * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User", inversedBy="comments")
   * @ORM\JoinColumn(nullable=false)
   */
  private $user;

  /**
  * @var string
  * @ORM\Column(name="content", type="text")
  */

  private $content;


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

  /**
  * @param User $user
  */
  public function setUser(User $user)
  {
    $this->user = $user;
  }

  /**
  * @return User $user
  */

  public function getUser()
  {
    return $this->user;
  }

  /**
  * @return string $content
  */
  public function setContent($content)
  {
    $this->content = $content;
  }
  /**
   *
   * @return string
  */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @param Article $article
   */
  public function setArticle(Article $article)
  {
    $this->article = $article;
  }

  /**
   * @return Article $article
   */
  public function getArticle()
  {
    return $this->article;
  }
}
