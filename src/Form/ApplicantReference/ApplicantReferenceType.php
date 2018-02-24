<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 17:17
 */

namespace App\Form\ApplicantReference;


use App\Entity\ApplicantReference;
use App\Form\Base\BaseAbstractType;
use App\Form\Traits\Contact\ContactType;
use App\Form\Traits\Person\PersonType;
use App\Form\Traits\Thing\ThingType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicantReferenceType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('thing', ThingType::class, ["label" => false, "inherit_data" => true]);
        $builder->add('person', PersonType::class, ["inherit_data" => true]);
        $builder->add('contact', ContactType::class, ["inherit_data" => true]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_applicant_reference',
            'data_class' => ApplicantReference::class
        ]);
    }
}