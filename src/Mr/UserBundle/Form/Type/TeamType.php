<?php


namespace Mr\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'label' => 'mr.user.team.name.label'
            ))
            ->add('number', 'integer', array(
                'required' => true,
                'label' => 'mr.user.team.number.label'
            ))
            ->add('userteam', 'collection', array(
                'type' => 'mr_user_userteam',
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'mr.user.team.userteam.label'
            ))
            ->add('save', 'submit', array(
                'label' => 'mr.user.team.submit'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Mr\UserBundle\Entity\Team'));
    }

    public function getName() {
        return 'mr_user_team';
    }
}