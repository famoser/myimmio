<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 24/02/2018
 * Time: 07:36
 */

namespace App\Form\Apartment;


use App\Entity\Apartment;
use App\Form\Base\BaseAbstractType;
use App\Form\Traits\Thing\ThingType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartmentType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("thing", ThingType::class, ["label" => false, "inherit_data" => true]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_apartment',
            'data_class' => Apartment::class
        ]);
    }
}