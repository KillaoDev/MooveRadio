<?php


namespace Mr\BookBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('content', 'textarea', array(
                'required' => true,
                'label' => 'mr.book.message.content.label'
            ))
            ->add('save', 'submit', array(
                'label' => 'mr.book.message.submit'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Mr\BookBundle\Entity\Message'));
    }

    public function getName() {
        return 'mr_book_message';
    }
}