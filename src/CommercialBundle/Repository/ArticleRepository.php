<?php

namespace CommercialBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function findByNom($nom)
    {
        $qb = $this->createQueryBuilder('article');

        $qb
            ->where('article.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')

        ;

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}
