<?php

namespace ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ThreadRepository extends EntityRepository
{
  public function getThread($id)
  {
    $qb = $this->createQueryBuilder('thread');

    $qb
      ->leftJoin('thread.post', 'post')
      ->where('thread.id = :id')
      ->setParameter('id', $id);

    return $qb->getQuery()->getResult();
  }
}
