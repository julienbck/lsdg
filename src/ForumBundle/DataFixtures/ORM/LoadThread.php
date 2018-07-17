<?php

namespace FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ForumBundle\Entity\Thread;


class LoadThread implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $names = array('Technologies', 'Informatique', 'Smartphone', 'Jeux-vidéos', 'Robotique', 'Divers');

    foreach ($names as $name) {
      $thread = new Thread();
      $thread->setName($name);

      $manager->persist($thread);
    }
    $manager->flush();
  }
}
