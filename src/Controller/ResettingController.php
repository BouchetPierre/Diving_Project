<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use \Swift_Mailer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Entity\Member;
use App\Repository\MemberRepository;
use App\Services\MailerService;
use App\Form\ResettingType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
    /**
     * @Route("/renouvellement-mot-de-passe")
     */
class ResettingController extends AbstractController
{
    /**
     * @Route("/requete", name="request_resetting")
     */
    public function request(Request $request, MailerService $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        // création d'un formulaire  afin que l'internaute puisse renseigner son mail
        $form = $this->createFormBuilder()
            ->add('mail',TextType::class, [
                'label' => 'Votre mail'
                ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(Member::class)->loadUserByUsername($form->getData()['mail']);

            // aucun email associé à ce compte.
            if (!$user) {
                $request->getSession()->getFlashBag()->add('danger', "Cet email n'existe pas.");
                return $this->redirectToRoute("request_resetting");
            }

            // création du token
            $user->setToken($tokenGenerator->generateToken());
            // enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new \Datetime());
            $em->flush();

            // on utilise le service Mailer créé précédemment
            $bodyMail = $mailer->createBodyMail('resetting/mail.html.twig', [
                'user' => $user
            ]);
            $mailer->sendMessage('bouchet.hp@gmail.com', $user->getMail(), 'renouvellement du mot de passe', $bodyMail);
            $request->getSession()->getFlashBag()->add('success', "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");

            return $this->redirectToRoute("account_login");
        }

        return $this->render('resetting/request.html.twig', [
            'form' => $form->createView()
        ]);
    }
    // si supérieur à 10min, retourne false
    // sinon retourne false
    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;
        }

        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }

    /**
     * @Route("/{id}/{token}", name="resetting")
     */
    public function resetting(Member $member, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // interdit l'accès à la page si:
        // le token associé au membre est null
        // le token enregistré en base et le token présent dans l'url ne sont pas égaux
        // le token date de plus de 10 minutes
        if ($member->getToken() === null || $token !== $member->getToken() || !$this->isRequestInTime($member->getPasswordRequestedAt()))
        {
            //throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ResettingType::class, $member);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($member, $member->getPassword());
            $member->setPassword($password);

            // réinitialisation du token à null pour qu'il ne soit plus réutilisable
            $member->setToken(null);
            $member->setPasswordRequestedAt(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre mot de passe a été renouvelé.");

            return $this->redirectToRoute('account_login');

        }

        return $this->render('resetting/index.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
