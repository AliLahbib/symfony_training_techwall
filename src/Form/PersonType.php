<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Person;
use App\Entity\Profile;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use function Sodium\add;

class PersonType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',)
            ->add('lastname')
            ->add('age', null, ['required' => true])
            ->add('avatar')
            ->add('name')
            ->add('createdAt', null, [
                'widget' => 'single_text'
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text'
            ])
//            ->add('profile', EntityType::class, [
//                'class' => Profile::class,
//                'choice_label' => 'rs',
//                "expanded" => true,
//                "required"=>false
//
//            ])
            ->add('rs', null, ['label' => 'reseau sociale'])
            ->add('url', null, ['label' => 'URL du profile'])
            ->add('jobTitle', null, ['label' => 'titre de travail'])
            ->add('hobbiesTitle', null, ['label' => 'Les Hobbies (séparées par "," )'])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'designation',
                "required"=>false,
                'attr' => ['class' => "select2"]
            ])
            ->add('hobbies', EntityType::class, [
                'class' => Hobby::class,
                'choice_label' => 'designation',
                'multiple' => true,
                "required" => false,
                //'attr' => ['class' => "select2"]
            ])
            ->add('image', FileType::class, [
                'label' => 'votre image de profile (des fichier images uniquement',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],

            ])
            ->add('save', SubmitType::class, [
                'label' => 'ajouter',
                'attr' => ['class' => 'btn btn-primary']
            ]);

        // Appel de la méthode pour ajouter le champ hobbies

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }


}
