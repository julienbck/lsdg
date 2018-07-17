<?php

namespace ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ForumRepository extends EntityRepository
{
  public function getForumWithSubForum()
  {
    $qb = $this->createQueryBuilder('forum');

    $query = $qb
      ->leftJoin('forum.subforum', 'subforum')
      ->leftJoin('subforum.thread', 'thread')
      ->leftJoin('thread.post', 'post')
      ->where('forum.id = subforum.forum')
      ->orderBy('forum.position')
      ->getQuery();


    return $query->getResult();

  }
  public function getNbThreadsAndPostsInSubforum(){

    $qb = $this->createQueryBuilder('forum');

    $query = $qb
      ->select(' count(thread.id) as nbThread', 'count(post.id) as nbPost', 'subforum.id')
      ->leftJoin('forum.subforum', 'subforum')
      ->leftJoin('subforum.thread', 'thread')
      ->leftJoin('thread.post', 'post')
      ->where('forum.id = subforum.forum')
      ->groupBy('thread.subforum')
      ->getQuery();

    return $query->getResult();
  }
// SELECT lsdg_subforum.id as subforumId, lsdg_thread.id as threadId, lsdg_post.content as Message, lsdg_post.date as Date, lsdg_post.user_id as userId, fos_user.username FROM lsdg_forum LEFT JOIN lsdg_subforum ON lsdg_forum.id = lsdg_subforum.forum_id LEFT JOIN lsdg_thread ON lsdg_subforum.id = lsdg_thread.subforum_id LEFT JOIN lsdg_post ON lsdg_thread.id = lsdg_post.thread_id LEFT JOIN fos_user ON lsdg_post.user_id = fos_user.id GROUP BY subforumId
//

}
