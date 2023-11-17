<?php

namespace Plugin\MailChimpAddContact\Form\Type\Admin;

use Plugin\MailChimpAddContact\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('server_prefix', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ])
        ->add('api_key', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ])
        ->add('list_id', TextType::class, [
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}
