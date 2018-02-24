<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 17:17
 */

namespace App\Form\Application;


use App\Entity\Applicant;
use App\Entity\Application;
use App\Enum\SalutationType;
use App\Form\ApplicationSlot\ApplicationSlotType;
use App\Form\Base\BaseAbstractType;
use App\Form\Traits\Address\AddressType;
use App\Form\Traits\Contact\ContactType;
use App\Form\Traits\Person\PersonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('applicants', CollectionType::class, [
            'allow_add' => true,
            'allow_delete' => true,
            'entry_type' => ApplicationSlotType::class
        ]);
        $builder->add('instruments', TextType::class);
        $builder->add('pets', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_application',
            'data_class' => Application::class
        ]);
    }
}