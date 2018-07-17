<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
* @ORM\Table(name="lsdg_article")
* @ORM\Entity(repositoryClass="FrontBundle\Repository\ArticleRepository")
*/

class Article
{
  /**
  * @var int
  *
  *@ORM\Column(name="id", type="integer")
  *@ORM\Id
  *@ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\ManyToMany(targetEntity="FrontBundle\Entity\Category", cascade={"persist"})
  */

  private $categories;

  /**
  * @var \DateTime
  *
  *@ORM\Column(name="date", type="datetime")
  */
  private $date;

  /**
  * @var string
  *
  * @ORM\Column(name="title", type="string", length=255)
  */
  private $title;

  /**
  * @var string
  *
  * @ORM\Column(name="author", type="string", length=255)
  */
  private $author;

  /**
  * @var string
  *
  * @ORM\Column(name="content", type="text")
  */
  private $content;

  /**
  * @ORM\Column(name="published", type="boolean")
  */
  private $published = true;

  /**
  * @ORM\OneToOne(targetEntity="FrontBundle\Entity\Image", cascade={"persist", "remove"})
  */
  private $image;

  /**
  * @ORM\OneToMany(targetEntity="FrontBundle\Entity\Comment", mappedBy="article")
  */
  private $comments;



  /**
  * @return int
  */
  public function getId()
  {
    return $this->id;
  }

  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->categories   = new ArrayCollection();
    $this->comments     = new ArrayCollection();
  }

  /**
  * @param \DateTime $date
  */
  public function setDate($date)
  {
    $this->date =$date;
  }

  /**
  * @return \DateTime
  */

  public function getDate()
  {
    return $this->date;
  }

  /**
  * @param string  $title
  */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
  * @return string
  */

  public function getTitle()
  {
    return $this->title;
  }

  /**
  * @param string $author
  */
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  /**
  * @return string
  */

  public function getAuthor()
  {
    return $this->author;
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
  * @param bool $published
  */
  public function setPublished($published)
  {
    $this->published = $published;
  }
  /**
  * @return bool
  */
  public function getPublished()
  {
    return $this->published;
  }

  /**
  * @return string $image
  */
  public function setImage($image)
  {
    $this->image = $image;
  }
  /**
  * @return string
  */
  public function getImage()
  {
    return $this->image;
  }

  /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
      $this->categories[] = $category;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
      $this->categories->removeElement($category);
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
      return $this->categories;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
      $this->comments[] = $comment;
      $comment->setUser($this);

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
     * @return ArrayCollection
     */
    public function getComment()
    {
      return $this->comments;
    }


    public function getWebPath()
   {
     return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
   }
}
