<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 17:17
 */

namespace App\Form\ApplicantLandlord;


use App\Entity\ApplicantLandlord;
use App\Form\ApplicantReference\ApplicantReferenceType;
use App\Form\Base\BaseAbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicantLandlordType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("relocationReason", TextType::class);
        $builder->add("noticeBy", TextType::class);
        $builder->add("rentingSince", TextType::class);
        $builder->add("reference", ApplicantReferenceType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_applicant_landlord',
            'data_class' => ApplicantLandlord::class
        ]);
    }
}