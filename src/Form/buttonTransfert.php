<?php

  namespace App\Form;

  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  use Symfony\Component\Validator\Constraints as Assert;

  class buttonTransfert extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
      $builder->add('send', SubmitType::class, [
          'label'           => 'Commencer à transférer',
      ]);
    }
  }

?>
