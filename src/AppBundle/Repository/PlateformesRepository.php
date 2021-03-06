<?php

namespace AppBundle\Repository;

/**
 * PlateformesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlateformesRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */

    public function findAllPlateformesBuilder($array_options = null)
    {
        $result = null;

        switch ($array_options['role'])
        {
            case 'ROLE_ADMINISTRATEUR':
            {
                $result =  $this->createQueryBuilder('a','a.id')
                                ->orderBy('a.nom', 'ASC');
                break;
            }

            case 'ROLE_RESPONSABLE':
            {
                $result =  $this->createQueryBuilder('a','a.id')
                                ->where  ('a.responsable = ?1')
                                ->orderBy('a.nom', 'ASC')
                                ->setParameter(1,$array_options['user_id']);
                break;
            }

            case 'ROLE_MEMBRE':
            {
                break;
            }

            case 'ROLE_VISITEUR':
            {
                break;
            }

            default :
            {
                $result =  $this->createQueryBuilder('a','a.id')
                                ->orderBy('a.nom', 'ASC');
                break;
            }
        }

        return $result;
    }

    public function findAllPlateformes($array_options = null)
    {
        return $this->findAllPlateformesBuilder($array_options)->getQuery()->getResult();
    }

    /**
     * @param int $nb
     * @return array
     */
    public function findLast($nb = 3)
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.updated', 'desc')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }
}
