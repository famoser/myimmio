<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 17:17
 */

namespace App\Form\Applicant;


use App\Entity\Applicant;
use App\Entity\ApplicantJob;
use App\Enum\SalutationType;
use App\Form\ApplicantJob\ApplicantJobType;
use App\Form\ApplicantLandlord\ApplicantLandlordType;
use App\Form\Base\BaseAbstractType;
use App\Form\Traits\Address\AddressType;
use App\Form\Traits\Contact\ContactType;
use App\Form\Traits\Person\PersonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicantType extends BaseAbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('salutation', ChoiceType::class, SalutationType::getChoicesForBuilder());
        $builder->add('person', PersonType::class, ["label" => false, "inherit_data" => true]);
        $builder->add('address', AddressType::class, ["inherit_data" => true]);
        $builder->add('contact', ContactType::class, ["inherit_data" => true]);
        $builder->add("birthDate", DateType::class);
        $builder->add("civilStatus", TextType::class);
        $builder->add("nationality", CountryType::class, ['preferred_choices' => array('CH')]);
        $builder->add("residenceAuthorization", TextType::class);
        $builder->add("applicantJob", ApplicantJobType::class);
        $builder->add("landLord2", ApplicantLandlordType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'entity_applicant',
            'data_class' => Applicant::class
        ]);
    }
}