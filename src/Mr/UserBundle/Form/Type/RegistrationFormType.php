<?php
namespace Mr\UserBundle\Form\Type;

use Mr\UserBundle\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder
            ->remove('email')
            ->add('email', 'repeated', array(
                'type' => 'email',
                'first_options' => array('label' => 'mr.user.registration.email.first'),
                'second_options' => array('label' => 'mr.user.registration.email.second'),
                'invalid_message' => 'mr.user.registration.email.mismatch',
                'required' => true
            ))
            ->add('birthdate', 'birthday', array(
                'required' => false,
                'label' => 'mr.user.registration.birthdate.label'
            ))
            ->add('country', 'country', array(
                //'empty_value' => 'mr.user.registration.country.label'
            ))
            ->add('city', 'text', array(
                'required' => false,
                'label' => 'mr.user.registration.city.label'
            ))
            ->add('gender', 'choice', array(
                'choices' => array(
                    User::GENDER_STR_MALE => 'mr.user.registration.gender.male',
                    User::GENDER_STR_FEMALE => 'mr.user.registration.gender.female',
                    User::GENDER_STR_UNDEFINED => 'mr.user.registration.gender.undefined'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'mr.user.registration.gender.label'
            ))
            ->add('newsletter', 'checkbox', array(
                'required' => false,
                'label' => 'mr.user.registration.newsletter.label'
            ))
            ->add('save', 'submit', array(
                'label' => 'mr.user.registration.submit'
            ));
    }

    public function getName() {
        return 'mr_user_registration';
    }
}