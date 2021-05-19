<?php
/**
 * Created by PhpStorm.
 * User: c00338
 * Date: 17/01/2018
 * Time: 10:38
 */

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use  Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prenom', TextType::class)
                ->add('nom', TextType::class);
    }




}