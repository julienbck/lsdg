<?php

namespace ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

  /**
  * @ORM\Entity(repositoryClass="ForumBundle\Repository\SubforumRepository")
  * @ORM\Table(name="lsdg_subforum")
  */
class Subforum
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
  * @var int
  * @ORM\Column(name="position", type="integer")
  */
  private $position;

  /**
  * @var string
  * @ORM\Column(name="description", type="text")
  */

  private $description;

  /**
   * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Forum", inversedBy="subforum")
   * @ORM\JoinColumn(nullable=false)
   */
  private $forum;

  /**
  * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Thread", mappedBy="subforum")
  */
  private $thread;

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

  public function setPosition($position)
  {
    $this->position = $position;
  }

  public function getPosition()
  {
    return $this->position;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getForum()
  {
    return $this->forum;
  }

  public function getThread()
  {
    return $this->thread;
  }
}
