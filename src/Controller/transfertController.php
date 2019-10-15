<?php
namespace App\Controller;

use App\Form\formTransfert;
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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;
use sendMail;
use ZipArchive;


class transfertController extends AbstractController {
  /**
   * @Route("/")
   */
  public function index(Request $request) {
      $form = $this->createForm(FormType::class)->add('send', SubmitType::class, ['label' => 'Commencer à transférer']);
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
  public function new(Request $request, \Swift_Mailer $mailer) {
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

      $form = $formBuilder->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $elements = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $originalName = $request->files->get('form')['fileName']->getClientOriginalName();

        $zipName = $elements->getName().'-'.uniqid() . '.zip';
        $zipfile = new ZipArchive();
        $zipfile->open($this->getParameter('file_directory') . $zipName, ZipArchive::CREATE);
        $zipfile->addFile($elements->getFileName(), $originalName);
        $zipfile->close();
        $elements->setFileName($zipName);

        $entityManager->persist($elements);
        $entityManager->flush();

        $message = (new \Swift_Message())
          ->setSubject('EasyTransfer - Fichiers envoyés par ' . $elements->getName())
          ->setFrom([$elements->getSender()])
          ->setTo([$elements->getReceiver()]);

          // $cid = $message->embed(\Swift_Image::fromPath('img/logo.png'));
          $message->setBody(
            $this->renderView('email.txt.twig', [
                // 'nomDestinataire' => $elements->getName(),
                // 'nomAuteur' => $elements->getSender(),
                'link' => 'uploads/' . $zipName /*,
                'imgLogo' => $cid */
            ]),
            'text/html'
          );

          $mailer->send($message);

        // $this->sendM('test');

        return $this->render('transfertSuccess.html.twig');

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
