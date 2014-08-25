<?php

namespace Mr\BookBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends EntityRepository {
    public function listPage($language, $page, $limit=50) {
        return $this->createQueryBuilder('m')
                   ->where('m.language = :language')
                   ->setParameter('language', $language)
                   ->setFirstResult(($page-1) * $limit)
                   ->setMaxResults($limit)
                   ->getQuery()
                   ->getResult();
    }

    public function count($language) {
        return $this->createQueryBuilder('m')
                    ->select('count(m)')
                    ->where('m.language = :language')
                    ->setParameter('language', $language)
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}