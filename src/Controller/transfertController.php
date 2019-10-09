<?php
namespace App\Controller;

use App\Form\formTransfert;
use App\Form\buttonTransfert;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


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
      $form = $this->createForm(formTransfert::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
           // $myForm = $form->getData();

           // ... perform some action, such as saving the task to the database
           // for example, if Task is a Doctrine entity, save it!
           // $entityManager = $this->getDoctrine()->getManager();
           // $entityManager->persist($task);
           // $entityManager->flush();

           return $this->redirectToRoute('transfert_success', array(
                    'value' => $form->getData())
                  );

       }

      return $this->render('transfertPage.html.twig', [
        'form' => $form->createView(),
      ]);
  }

  /**
   * @Route("/transfert_success", name="transfert_success")
   */
  public function success($infos) {
      return $this->render('transfertSuccess.html.twig', [
            'infos' => $infos,
        ]);
  }
}
