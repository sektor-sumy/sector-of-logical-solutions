<?php

namespace AppBundle\Repository;

/**
 * Class UserRepository
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByRole($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"' . $role . '"%');

        return $qb->getQuery()->getResult();
    }
}
