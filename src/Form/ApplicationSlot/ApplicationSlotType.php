<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 17:17
 */

namespace App\Form\ApplicationSlot;


use App\Entity\ApplicationSlot;
use App\Form\Base\BaseAbstractType;
use App\Form\Traits\Thing\ThingType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationSlotType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('thing', ThingType::class, ["label" => false, "inherit_data" => true]);
        $builder->add('startAt', DateTimeType::class);
        $builder->add('endAt', DateTimeType::class);
        $builder->add('welcomeHeader', TextType::class);
        $builder->add('welcomeText', TextareaType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_application_slot',
            'data_class' => ApplicationSlot::class
        ]);
    }
}