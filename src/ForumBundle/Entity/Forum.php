<?php


namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ForumRepository")
 * @ORM\Table(name="lsdg_forum")
 */
class Forum
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
  *
  * @ORM\Column(name="name", type="string", length=255)
  */
  private $name;

  /**
  * @var string
  * @ORM\Column(name="description", type="string", length= 255)
  *
  */
  private $description;


  /**
  * @var int
  * @ORM\Column(name="position", type="integer")
  */
  private $position;

  /**
  * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Subforum", mappedBy="forum", fetch="EAGER")
  */
  private $subforum = [];


  public function __construct()
  {
     $this->subforum = new ArrayCollection;
  }
  public function getId()
  {
    return $this->id;
  }

  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }

  /**
  * @return string
  */
  public function getDescription()
  {
    return $this->description;
  }

  /**
  * @param string $description
  */
  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function setPosition($position)
  {
    $this->position = $position;
  }

  public function getPosition()
  {
    return $this->position;
  }

  public function setSubforum($subforum)
  {
    $this->subforum = $subforum;
  }

  /**
   * @return ArrayCollection;
   */
  public function getSubforum()
  {
    return $this->subforum;
  }
}
