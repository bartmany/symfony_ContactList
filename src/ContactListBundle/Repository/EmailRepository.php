<?php

namespace ContactListBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EmailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmailRepository extends EntityRepository
{
    public function findAllById($id)
    {
        $dql = "SELECT email FROM ContactListBundle:Email email WHERE email.contact = :id";

        $emails = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id)->getResult();

        return $emails;
    }
}
