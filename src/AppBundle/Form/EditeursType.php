<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditeursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array(
            'label'              => 'Nom',
            'required'           => true,
        ))
            ->add('lien', TextType::class, array(
                'label'              => 'Site Web',
                'required'           => false,
            ))
            ->add('ville', TextType::class, array(
                'label'              => 'Ville',
                'required'           => false,
            ))
            ->add('pays', EntityType::class, array(
                'class'              => 'AppBundle\Entity\Pays',
                'choice_label'       => 'nomFr',
                'label'              => 'Pays',
                'required'           => true,
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Editeurs',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_editeurs';
    }


}
