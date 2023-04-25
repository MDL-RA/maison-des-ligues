<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordRequestFormType extends AbstractType
{
    /**
     * Formulaire permettant d'envoyer la demande réinitialisation de mot de passe
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numLicence', NumberType::class, [
                'attr' => [
                    'min' => 00000000001,
                    'max' => 99999999999,
                ],
                'constraints' => [
                    new Length([
                        'min' => 11,
                        'exactMessage' => 'Le numéro de licencié doit contenir 11 caractères !',
                        'max' => 11,
                    ]),
                    new Regex([
                        'message' => 'Veuillez saisir un numéro de licencié valide !',
                        'pattern' => '/^[0-9]*$/',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
