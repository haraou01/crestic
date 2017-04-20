<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PublicationsHasPlateformes;

/**
 * PublicationsHasPlateformesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationsHasPlateformesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllPlateformesFromPublicationBuilder($id_publication)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->where('a.publication = ?1')
            ->setParameter(1,$id_publication);
    }

    public function findAllPlateformesFromPublication ($id_publication)
    {
        return $this->findAllPlateformesFromPublicationBuilder($id_publication)->getQuery()->getResult();
    }

    public function getArrayIdFromPublicationPlateformes ($id_publication)
    {
        $result = array();
        $array  =  $this->findAllPlateformesFromPublication($id_publication);

        foreach ($array as $key=>$value)
        {
            $id = $value->getPlateforme()->getId();
            $result[] = $id;
        }
        return $result;
    }

    public function findLastPublicationsFromPlateformeBuilder($id_plateforme, $nb)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->innerJoin('CRESTICPublicationsBundle:Publications', 'p', 'WITH', 'a.publication = p.id')
            ->where('a.plateforme = ?1')
            ->setParameter(1, $id_plateforme)
            ->orderBy('p.anneePublication', 'DESC')
            ->orderBy('p.moisPublication', 'DESC')
            ->setMaxResults($nb);
    }

    public function findLastPublicationsFromPlateforme ($id_plateforme, $nb)
    {
        return $this->findLastPublicationsFromPlateformeBuilder($id_plateforme, $nb)->getQuery()->getResult();
    }

    public function findAllIdPlateformes($idpublication)
    {
        $plateformes = $this->findAllPlateformesFromPublication($idpublication);
        $t =array();
        /** @var PublicationsHasPlateformes $e */
        foreach ($plateformes as $e)
        {
            $t[$e->getPlateforme()->getId()] = $e;
        }

        return $t;
    }
}
