<?php

namespace AppBundle\Form;

use AppBundle\Entity\PageTranslation;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use MongoDB\BSON\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, [
                'label' => 'Slug '
            ])
            ->add('title', TextType::class, [
                'label' => 'Title '
            ])
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('content')
            ->add('contentEn', TextType::class, ['mapped' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Page'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_page';
    }
}
