<?php

namespace AppBundle\Form;

use AppBundle\Entity\ReferentFamilial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PatientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime("now");
        $builder
            ->add('dateNaissance', DateType::class, array(
                'label' => 'Date de naissance',
                'years' => range(1900, $date->format('Y')),
                'required' => true
            ))
            ->add('nom', TextType::class, array(
                'required' => true
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'required' => true))
            ->add('genre', ChoiceType::class, array(
                'choices' => array(
                'Masculin'=> false,
                'Féminin'=> true
                ),
                'label'=>'Genre'

            ))
            ->add('adresse', TextType::class, array('required' => false))
            ->add('fixe', TextType::class, array('required' => false))
            ->add('portable', TextType::class, array('required' => false))
            ->add('mail', EmailType::class, array(
                'label' => 'E-mail',
                'required' => false))
            ->add('situationFamiliale', TextType::class, array('required' => false, 'label'=> 'Situation familiale'))
            ->add('situationPro', TextType::class, array('required' => false, 'label'=> 'Situation professionnelle'))
            ->add('Suivant', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Patient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_patient';
    }


}
