<?php

namespace FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CategoryRepository extends EntityRepository
{

      public function getCategoryId(){
        $qb = $this->createQueryBuilder('category');

        $query = $qb
        ->addSelect('category')
        ->getQuery();

        return $query->getResult();
      }
}
