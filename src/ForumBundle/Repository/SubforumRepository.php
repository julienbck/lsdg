<?php

namespace ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class SubforumRepository extends EntityRepository
{
  public function getSubforumWithThread($id)
  {
    $qb = $this->createQueryBuilder('subforum');

    $qb
      ->addSelect('thread')
      ->leftJoin('subforum.thread', 'thread')
      ->where('subforum.id = :id')
      ->setParameter('id', $id);

    return $qb->getQuery()->getResult();
  }

  public function getNbThreadAndPost($id)
  {
    $qb = $this->createQueryBuilder('subforum');

    $qb
      ->select(' count(post.id) as posts')
      ->leftJoin('subforum.thread', 'thread')
      ->leftJoin('thread.post', 'post')
      ->where('subforum.id = :id')
      ->setParameter('id', $id);

    return $qb->getQuery()->getResult();
  }
  // SELECT lsdg_subforum.id as subforumId, lsdg_thread.id as threadId, lsdg_post.content as Message, lsdg_post.date as Date, lsdg_post.user_id as userId, fos_user.username FROM lsdg_forum LEFT JOIN lsdg_subforum ON lsdg_forum.id = lsdg_subforum.forum_id AND lsdg_subforum.id = 1 LEFT JOIN lsdg_thread ON lsdg_subforum.id = lsdg_thread.subforum_id LEFT JOIN lsdg_post ON lsdg_thread.id = lsdg_post.thread_id LEFT JOIN fos_user ON lsdg_post.user_id = fos_user.id ORDER BY Date DESC LIMIT 1
    public function getLastAuthor($subforumId){
      $qb = $this->createQueryBuilder('subforum');

      $query = $qb
      ->select( 'subforum.id as subforumId', 'thread.id as threadId', 'post.content as Message', 'post.date as Date', 'user.username')
      ->leftJoin('subforum.thread', 'thread')
      ->leftJoin('thread.post', 'post')
      ->leftJoin('post.user', 'user')
      ->where('subforum.id = :id')
      ->setParameter('id', $subforumId)
      ->addOrderBy('Date','DESC')
      ->setMaxResults(1)
      ->getQuery();

      return $query->getScalarResult();
    }

    public function getSubforumId(){
      $qb = $this->createQueryBuilder('subforum');

      $query = $qb
      ->addSelect('subforum')
      ->getQuery();

      return $query->getResult();
    }
}
