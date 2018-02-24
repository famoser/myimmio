<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 17:17
 */

namespace App\Form\ApplicantJob;


use App\Entity\ApplicantJob;
use App\Form\ApplicantReference\ApplicantReferenceType;
use App\Form\Base\BaseAbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicantJobType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("workingSince", DateTimeType::class);
        $builder->add("profession", TextType::class);
        $builder->add("yearlySalary", NumberType::class);
        $builder->add("reference", ApplicantReferenceType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_applicant_job',
            'data_class' => ApplicantJob::class
        ]);
    }
}