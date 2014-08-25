<?php


namespace Mr\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserTeamType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'mr.user.userteam.title.label'
            ))
            ->add('content', 'textarea', array(
                'required' => true,
                'label' => 'mr.user.userteam.content.label'
            ))
            ->add('user', 'entity', array(
                'class' => 'MrUserBundle:User',
                'property' => 'username',
                'required' => true,
                'label' => 'mr.user.userteam.user.label'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Mr\UserBundle\Entity\UserTeam'));
    }

    public function getName() {
        return 'mr_user_userteam';
    }
}