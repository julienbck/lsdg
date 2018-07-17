<?php

namespace FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FrontBundle\Entity\Category;


class LoadCategory implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $names = array('Technologies', 'Informatique', 'Smartphone', 'Jeux-vidéos', 'Robotique', 'Divers');

    foreach ($names as $name) {
      $category = new Category();
      $category->setName($name);

      $manager->persist($category);
    }
    $manager->flush();
  }
}
