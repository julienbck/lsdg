<?php

namespace FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ArticleRepository extends EntityRepository
{
  public function getArticleWithCategories($categoryId)
  {
    $qb = $this->createQueryBuilder('a');

    // On fait une jointure avec l'entité Category avec pour alias « c »
    $qb
      ->innerJoin('a.categories', 'c')
      ->addSelect('c')
    ;

    // Puis on filtre sur le nom des catégories à l'aide d'un IN
    $qb->where($qb->expr()->in('c.id', $categoryId));

    // La syntaxe du IN et d'autres expressions se trouve dans la documentation Doctrine

    // Enfin, on retourne le résultat
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }
  public function getArticleWithCategoriesLimit($categoryId)
  {
    $qb = $this->createQueryBuilder('a');

    // On fait une jointure avec l'entité Category avec pour alias « c »
    $qb
      ->innerJoin('a.categories', 'c')
      ->addSelect('c')
    ;

    // Puis on filtre sur le nom des catégories à l'aide d'un IN
    $qb->where($qb->expr()->in('c.id', $categoryId));

    $qb->orderBy('a.date', 'DESC');
    $qb->setMaxResults(6);

    // La syntaxe du IN et d'autres expressions se trouve dans la documentation Doctrine

    // Enfin, on retourne le résultat
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }
  public function getArticleWithCommentAndNoComment($articleId)
  {
    // SELECT lsdg_article.*, comment.*, fos_user.username FROM lsdg_article LEFT JOIN comment ON lsdg_article.id = comment.article_id LEFT JOIN fos_user ON comment.user_id = fos_user.id
    $qb = $this->createQueryBuilder('a');


    $qb
      ->leftJoin('a.comments','c')
      ->leftJoin('c.user','u')
      ->addSelect('c')
      ->addSelect('u')
      ->where('a.id = :id')
      ->setParameter('id', $articleId)
      ;

      return $qb->getQuery()->getSingleResult();
  }
}
