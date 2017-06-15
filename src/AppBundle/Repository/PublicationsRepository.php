<?php

namespace AppBundle\Repository;

/**
 * PublicationsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllPublicationsBuilder ()
    {
        return $this->createQueryBuilder('a','a.id')
            ->orderBy('a.anneePublication', 'DESC');
    }

    public function findAllPublications ()
    {
        $result =  $this->findAllPublicationsBuilder()->getQuery()->getResult();
        return $result;
    }

    public function findLastPublications ()
    {
        return $this->createQueryBuilder('q')
                ->orderBy('q.anneePublication', 'DESC')
                ->addOrderBy('q.moisPublication', 'DESC')
                ->setMaxResults(20)
                ->getQuery()
                ->getResult();
    }

    public function findAllPublicationsFromMembre($id_membre)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->innerJoin('AppBundle:PublicationsHasMembres', 'p', 'WITH', 'a.id = p.publication')
            ->where('p.membreCrestic = ?1')
            ->orderBy('a.anneePublication', 'DESC')
            ->setParameter(1,$id_membre)
            ->getQuery()
            ->getResult();
    }


    public function findSearchPublicationsBuilder ($type_publication,$data)
    {
        $qb = $this->createQueryBuilder('a');
        //$qb->select ('a.id');

        $qb->innerJoin($type_publication, 'typu'  , 'WITH' , 'a.id = typu.id');

        $equipe_id = $data['equipe'];
        if ($equipe_id != '')
        {
            if ($equipe_id == "-2")
            {

            }
            else
            {
                if ($equipe_id == "-1")
                {

                    $qb->innerJoin('AppBundle:PublicationsHasEquipes', 'eq'  , 'WITH' , 'a.id = eq.publication');
                }
                else
                {
                    $qb->innerJoin('AppBundle:PublicationsHasEquipes', 'eq'  , 'WITH' , 'a.id = eq.publication AND eq.equipe = :equipe_id');
                    $qb->setParameter('equipe_id' ,$equipe_id);
                }
            }
        }

        $projet_id = $data['projet'];
        if ($projet_id != '')
        {
            if ($projet_id == "-2")
            {

            }
            else
            {
                if ($projet_id == "-1")
                {
                    $qb->innerJoin('AppBundle:PublicationsHasProjets', 'pr'  , 'WITH' , 'a.id = pr.publication');
                }
                else
                {
                    $qb->innerJoin('AppBundle:PublicationsHasProjets', 'pr'  , 'WITH' , 'a.id = pr.publication AND pr.projet = :projet_id');
                    $qb->setParameter('projet_id' ,$projet_id);

                }
            }
        }


        $departement_id = $data['departement'];
        if ($departement_id != '')
        {
            if ($departement_id == "-1")
            {
            }
            else
            {
                $qb->innerJoin('AppBundle:PublicationsHasEquipes', 'pueq', 'WITH' , 'a.id        = pueq.publication');
                $qb->innerJoin('AppBundle:EquipesHasDepartements'     , 'de'  , 'WITH' , 'pueq.equipe = de.equipe AND de.departement = :departement_id');
                $qb->setParameter('departement_id' ,$departement_id);
            }

        }

        $auteur = $data['auteur'];
        if ($auteur != '')
        {
            $qb->innerJoin('AppBundle:PublicationsHasMembres' , 'pume' , 'WITH' , 'a.id                    = pume.publication');
            $qb->leftJoin('AppBundle:MembresCrestic'               , 'mc'   , 'WITH' , 'pume.membreCrestic      = mc.id');
            $qb->leftJoin('AppBundle:MembresExterieurs'            , 'me'   , 'WITH' , 'pume.membreExterieur    = me.id');
            $qb->where(' CONCAT(mc.prenom,mc.nom) LIKE :auteur OR CONCAT(mc.nom,mc.prenom) LIKE :auteur OR CONCAT(me.prenom,me.nom) LIKE :auteur OR CONCAT(me.nom,me.prenom) LIKE :auteur');
            $qb->setParameter('auteur' ,'%'.$auteur.'%');
        }

        $keywords = $data['keywords'];
        if ($keywords != '')
        {
            $qb->where('a.keywords LIKE :keywords OR a.titre LIKE :keywords OR a.resume LIKE :keywords OR a.commentaire LIKE :keywords');
            $qb->setParameter('keywords',"%".$keywords."%");
        }

        $dateDebut  = $data['dateDebut'];
        $dateFin    = $data['dateFin'];
        if ($dateDebut != '' && $dateFin != '')
        {

            $array_dateDebut    = explode("/", $dateDebut);
            $array_dateFin      = explode("/", $dateFin);
            $dateDebut_mois     = $array_dateDebut[1];
            $dateDebut_annee    = $array_dateDebut[2];
            $dateFin_mois       = $array_dateFin[1];
            $dateFin_annee      = $array_dateFin[2];


            $qb->where(':dateDebut_mois <= a.moisPublication AND a.moisPublication <= :dateFin_mois AND :dateDebut_annee <= a.anneePublication AND a.anneePublication <= :dateFin_annee');

            $qb->setParameter('dateDebut_mois' ,$dateDebut_mois);
            $qb->setParameter('dateFin_mois'   ,$dateFin_mois);
            $qb->setParameter('dateDebut_annee',$dateDebut_annee);
            $qb->setParameter('dateFin_annee'  ,$dateFin_annee);
        }



        return $qb;

    }

    public function findSearchPublications ($type_publication,$data)
    {
        $result =  $this->findSearchPublicationsBuilder($type_publication,$data)->getQuery()->getResult();
        return $result;
    }

    public function count()
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
