<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType {

    /**
     * Formulaire de la création de compte
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void {
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
                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'mapped' => false,
                    'invalid_message' => 'les mots de passe saisis ne sont pas identiques.',
                    'required' => true,
                    'attr' => ['autocomplete' => 'new-password'],
                    'first_options'=>[
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Veuillez renseigner un mot de passe',
                            ]),
                            new Length([
                                'min' => 8,
                                'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                                // max length allowed by Symfony for security reasons
                                'max' => 20,
                            ]),
                            new Regex([
                                'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/',
                                'message' => 'Votre mot de passe ne respecte pas au moins l\'une des conditions requises',
                            ]),
                        ],
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }

}
