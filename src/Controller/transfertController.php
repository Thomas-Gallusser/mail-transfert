<?php
namespace App\Controller;

use App\Form\formTransfert;
use App\Form\buttonTransfert;
use App\Entity\EntityTransfert;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class transfertController extends AbstractController {
  /**
   * @Route("/")
   */
  public function index(Request $request) {
      $form = $this->createForm(buttonTransfert::class);
      $form->handleRequest($request);
      if ($form->isSubmitted()) {
           return $this->redirectToRoute('transfert');
       }

      return $this->render('transfertIndex.html.twig', [
        'btn' => $form->createView(),
      ]);
  }

  /**
   * @Route("/transfert", name="transfert")
   */
  public function new(Request $request) {
      $envoie = new EntityTransfert();
      $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $envoie);

      $formBuilder
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
                ->add('fileName', FileType::class, [
                    'label'           => 'Fichier à envoyer: ',
                    'required'        => true,
                ])
                ->add('send', SubmitType::class, [
                    'label'           => 'Envoyer le(s) fichier(s)',
                ]);

      // $form = $this->createForm(formTransfert::class);
      $form = $formBuilder->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          dump($form->getData());
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
           // $myForm = $form->getData();

           // ... perform some action, such as saving the task to the database
           // for example, if Task is a Doctrine entity, save it!
           // $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->persist($task);
           // $entityManager->flush();

           return $this->render('transfertSuccess.html.twig', [
             'data' => $form->getData(),
           ]);

       }

      return $this->render('transfertPage.html.twig', [
        'form' => $form->createView(),
      ]);
  }

  /**
   * @Route("/transfert_success", name="transfert_success")
   */
  public function success($infos) {
      return $this->render('transfertSuccess.html.twig');
  }
}
