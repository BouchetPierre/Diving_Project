<?php

namespace App\Controller;

use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use http\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     * @IsGranted("ROLE_USER")
     * @return Response
     */

   public function index(Request $request, \Swift_Mailer $mailer)
   {
    $form = $this->createForm(MessageType::class);

    $form->handleRequest($request);

    $user= $this->getUser();

    if ($form->isSubmitted() && $form->isValid()) {
        $contactFormData = $form->getData();

        $message = (new \Swift_Message('You Got Mail!'))
                ->setFrom($user->getMail())
                ->setTo('bouchet.hp@gmail.com')
                ->setBody($contactFormData['message'],'text/plain');

        try{
            $mailer->send($message);
        }catch(\Exception $e){
            $this->addFlash('danger', 'Il y a une erreur'.$e);
        }




        $this->addFlash('success', 'Votre message a été envoyé !');

          return $this->redirectToRoute('message');
        }

    return $this->render('message/index.html.twig', [
        'form' => $form->createView()
    ]);
    }
}
