<?php

namespace AppBundle\Repository;

/**
 * OrganigrammeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrganigrammeRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param $responsabiliteFonction
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllOrganigrammeBuilder($responsabiliteFonction)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->where ('a.responsabiliteFonction = ?1' )
            ->innerJoin('a.membreCrestic','b')
            ->orderBy('a.ordre','asc')
            ->setParameter(1,$responsabiliteFonction);
    }

    /**
     * @return array
     */

    public function findAllOrganigramme($responsabiliteFonction)
    {
        $result = array();
        $array = $this->findAllOrganigrammeBuilder($responsabiliteFonction)->getQuery()->getResult();


        foreach ($array as $key=>$value)
        {
            $result[] = $value->getMembreCrestic();
        }
        return $result;
    }



}
