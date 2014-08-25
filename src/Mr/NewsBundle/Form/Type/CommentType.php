<?php


namespace Mr\NewsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'mr.news.comment.title.label'
            ))
            ->add('content', 'textarea', array(
                'required' => true,
                'label' => 'mr.news.comment.content.label'
            ))
            ->add('save', 'submit', array(
                'label' => 'mr.news.comment.submit'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Mr\NewsBundle\Entity\Comment'));
    }

    public function getName() {
        return 'mr_news_comment';
    }
}