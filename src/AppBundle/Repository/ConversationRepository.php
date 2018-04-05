<?php

namespace AppBundle\Repository;

/**
 * Class ConversationRepository
 */
class ConversationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $hash
     * @return array
     */
    public function getConversationByHash($hash)
    {
        $query = $this->createQueryBuilder('c')
            ->select('')
            ->leftJoin('c.conversationReplies', 'cr')
            ->where('c.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery();

        return $query->getArrayResult();
    }
}
