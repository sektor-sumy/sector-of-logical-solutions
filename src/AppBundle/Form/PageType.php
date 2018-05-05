<?php

namespace AppBundle\Form;

use AppBundle\Entity\Page;
use AppBundle\Entity\PageTranslation;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use MongoDB\BSON\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, ['label' => 'Slug '])
            ->add('titleEn', TextType::class, ['mapped' => false, 'label' => 'Title'])
            ->add('titleRu', TextType::class, ['mapped' => false, 'label' => 'Title'])
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->add('contentEn', TextareaType::class, ['mapped' => false, 'label' => 'Content'])
            ->add('contentRu', TextareaType::class, ['mapped' => false, 'label' => 'Content'])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                // ...
                $form = $event->getForm();
                /** @var Page $data */
                $data = $event->getData();

                $data->setTitle($form->get('titleEn')->getData());
                $data->translate('en')->setTitle($form->get('titleEn')->getData());
                $data->translate('ru')->setTitle($form->get('titleRu')->getData());

                $data->setContent($form->get('contentEn')->getData());
                $data->translate('en')->setContent($form->get('contentEn')->getData());
                $data->translate('ru')->setContent($form->get('contentRu')->getData());
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                // ...
                $form = $event->getForm();
                /** @var Page $data */
                $data = $event->getData();
                $event->getForm()->get('titleEn')->setData($data->translate('en')->getTitle());
                $event->getForm()->get('titleRu')->setData($data->translate('ru')->getTitle());
                $event->getForm()->get('contentEn')->setData($data->translate('en')->getContent());
                $event->getForm()->get('contentRu')->setData($data->translate('ru')->getContent());


            })
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
