<?php


namespace Mr\NewsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'mr.news.news.title.label'
            ))
            ->add('content', 'textarea', array(
                'required' => true,
                'label' => 'mr.news.news.content.label'
            ))
            ->add('image', 'url', array(
                'required' => false,
                'label' => 'mr.news.news.image.label'
            ))
            ->add('active', 'checkbox', array(
                'required' => false,
                'label' => 'mr.news.news.active.label'
            ))
            ->add('save', 'submit', array(
                'label' => 'mr.news.news.submit'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data_class' => 'Mr\NewsBundle\Entity\News'));
    }

    public function getName() {
        return 'mr_news_news';
    }
}