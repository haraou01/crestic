<?php

namespace AppBundle\Repository;
use AppBundle\Entity\PublicationsHasMembres;

/**
 * PublicationsHasMembresRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationsHasMembresRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllMembresFromPublicationBuilder($id_publication)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->where('a.publication = ?1')
            ->orderBy('a.position', 'ASC')
            ->setParameter(1,$id_publication);
    }

    public function findAllMembresFromPublication ($id_publication)
    {
        return $this->findAllMembresFromPublicationBuilder($id_publication)->getQuery()->getResult();
    }

    public function getArrayOfChoiceSelectPublicationHasMembre ($id_publication)
    {
        $result = array();
        $array  =  $this->findAllMembresFromPublication($id_publication);

        foreach ($array as $key=>$value)
        {
            if ($value->getMembreCrestic() != null)
            {
                $id = $value->getMembreCrestic()->getId();
                $result[] = 'membreCrestic_'.$id;
            }
            if ($value->getMembreExterieur() != null)
            {
                $id = $value->getMembreExterieur()->getId();
                $result[] = 'membreExterieur_'.$id;
            }

        }
        return $result;
    }

    /**
     * @return array
     */

    public function findAuteurMembreCresticBuilder($auteur)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->innerJoin('a.membreCrestic','b')
            ->where('CONCAT(b.prenom,b.nom) LIKE :auteur OR CONCAT(b.nom,b.prenom) LIKE :auteur')
            ->setParameter('auteur',"%".$auteur."%");
    }

    /**
     * @return array
     */

    public function findAuteurMembreCrestic($auteur)
    {
        return $this->findAuteurMembreCresticBuilder($auteur)->getQuery()->getResult();
    }

    /**
     * @return array
     */

    public function findAuteurMembreExterieurBuilder($auteur)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->innerJoin('a.membreExterieur','b')
            ->where('CONCAT(b.prenom,b.nom) LIKE :auteur OR CONCAT(b.nom,b.prenom) LIKE :auteur')
            ->setParameter('auteur',"%".$auteur."%");
    }

    /**
     * @return array
     */

    public function findAuteurMembreExterieur($auteur)
    {
        return $this->findAuteurMembreExterieurBuilder($auteur)->getQuery()->getResult();
    }

    public function findArrayAuteurs($publication)
    {
        $auteurs = $this->findAllMembresFromPublication($publication);
        $tjson = array();
        /** @var PublicationsHasMembres $auteur */
        foreach ($auteurs as $auteur)
        {
            if ($auteur->getMembreCrestic() !== null)
            {
                $t['id'] = $auteur->getMembreCrestic()->getId();
                $t['nom'] = $auteur->getMembreCrestic()->getNom();
                $t['prenom'] = $auteur->getMembreCrestic()->getPrenom();
                $t['type'] = 'crestic';
                $t['slug'] = $auteur->getMembreCrestic()->getSlug();
                } elseif ($auteur->getMembreExterieur() !== null)
            {
                $t['id'] = $auteur->getMembreExterieur()->getId();
                $t['nom'] = $auteur->getMembreExterieur()->getNom();
                $t['prenom'] = $auteur->getMembreExterieur()->getPrenom();
                $t['type'] = 'ext';
                $t['slug'] = $auteur->getMembreExterieur()->getId();
                } else
            {
                $t['nom'] = 'err';
                $t['prenom'] = 'err';
            }
            $t['position'] = $auteur->getPosition();
            $tjson[] = $t;
        }

        return $tjson;
    }
}
