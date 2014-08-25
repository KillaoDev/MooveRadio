<?php

namespace Mr\NewsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository {
    public function listPage($language, $page, $active=true, $limit=50) {
        $qb = $this->createQueryBuilder('n')
            ->where('n.language = :language')
            ->setParameter('language', $language);
        if ($active) {
            $qb->andWhere('n.active = true')
               ->orderBy('n.date', 'asc');
        }
        return $qb->setFirstResult(($page-1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByCanonical($canonical, $language, $active=true) {
        $qb = $this->createQueryBuilder('n')
            ->where('n.canonical = :canonical')
            ->setParameter('canonical', $canonical)
            ->andWhere('n.language = :language')
            ->setParameter('language', $language);
        if ($active) {
            $qb->andWhere('n.active = true');
        }
        return $qb->getQuery()->getOneOrNullResult();
    }
}
