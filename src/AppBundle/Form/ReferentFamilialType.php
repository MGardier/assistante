<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
class ReferentFamilialType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lieu')->add('nom')->add('prenom', TextType::class, array('label'=>'Prénom'))->add('adresse')->add('fixe')->add('portable')->add('mail', EmailType::class, array('label'=>'E-mail', 'required'=>false))
        ->add('Enregistrer',SubmitType::class );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ReferentFamilial'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_referentfamilial';
    }
}
