<?php

  namespace App\Form;

  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\FileType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  use Symfony\Component\Validator\Constraints\File;
  use Symfony\Component\Validator\Constraints as Assert;

  class formTransfert extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, [
                    'label'           => '',
                    'attr'            => ['placeholder' => 'Votre nom'],
                    'required'        => true,
                ])
                ->add('sender', TextType::class, [
                    'label'           => '',
                    'attr'            => ['placeholder' => 'Votre mail'],
                    'required'        => true,
                    'invalid_message' => 'Ce mail n\'est pas valide.',
                    'constraints'     => new Assert\Email(),
                  ])
                  ->add('receiver', TextType::class, [
                      'label'           => '',
                      'attr'            => ['placeholder' => 'Email de votre amis'],
                      'required'        => true,
                      'invalid_message' => 'Ce mail n\'est pas valide.',
                      'constraints'     => new Assert\Email(),
                  ])
                  ->add('file', FileType::class, [
                      'label'           => 'Fichier à envoyer: ',
                      'required'        => true,
                  ])
                  ->add('send', SubmitType::class, [
                      'label'           => 'Envoyer le(s) fichier(s)',
                  ]);
    }
  }

?>
