<?php


namespace Mr\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeleteType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('confirm', 'checkbox', array(
                'required' => true,
                'label' => 'mr.news.delete.confirm.label'
            ))
            ->add('save', 'submit', array(
                'label' => 'mr.news.delete.submit'
            ));
    }

    public function getName() {
        return 'mr_user_delete';
    }
}