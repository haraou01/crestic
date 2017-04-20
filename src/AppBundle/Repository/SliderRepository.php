<?php

namespace AppBundle\Repository;

/**
 * SliderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SliderRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */

    public function findAllSliderBuilder($array_options = null)
    {
        $result = null;

        switch ($array_options['role'])
        {
            case 'ROLE_ADMINISTRATEUR':
            {
                $result = $this->createQueryBuilder('a','a.id')
                               ->orderBy('a.url', 'ASC');
                break;
            }

            case 'ROLE_RESPONSABLE':
            {

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
                $result = $this->createQueryBuilder('a','a.id')
                               ->orderBy('a.url', 'ASC');
                break;
            }
        }

        return $result;
    }


    /**
     * @return array
     */

    public function findAllSlider($array_options = null)
    {
        return $this->findAllSliderBuilder($array_options)->getQuery()->getResult();
    }
}
