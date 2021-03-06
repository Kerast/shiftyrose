<?php

namespace CT\CoreBundle\Repository;

/**
 * DepartmentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DepartmentRepository extends \Doctrine\ORM\EntityRepository
{

    public function array_findAll()
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->addSelect('a')
            ->leftJoin('a.location', 'l')
            ->addSelect('l')
        ;

        return $qb
            ->getQuery()
            ->getArrayResult()
            ;
    }
}
