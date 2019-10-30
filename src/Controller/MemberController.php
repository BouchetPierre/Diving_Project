<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\PasswordUpdate;
use App\Form\MemberType;
use App\Entity\InscriptionNotification;
use App\Form\UserEditType;
use App\Repository\MemberRepository;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Persistence\ObjectManager;
use MongoDB\Driver\Manager;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use App\Form\PasswordUpdateType;


class MemberController extends AbstractController
{
    /**
     * Liste des membres
     * @IsGranted("ROLE_ADMIN")
     * @Route("/members/{page}", name="members_index", requirements={"page": "\d+"})
     */
    public function index(MemberRepository $repo, $page =1)
    {
        $limit = 6;
        $start = $page *  $limit - $limit;
        $total = count($repo->findAll());
        $pages = ceil($total / $limit);
        $members = $repo->findBy([], ['firstName'=>'ASC'], $limit, $start);

          return $this->render('member/index.html.twig', [
             'members'=> $members,
             'pages' => $pages,
             'page' => $page,
             'total'=> $total
        ]);
    }

    /**
     *
     * Création d'un membre
     * @IsGranted("ROLE_ADMIN")
     * @Route("/members/new", name="members_create")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function create(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer){

        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password= $encoder->encodePassword($member, $member->getPassword());
            $member->setPassword($password);

            $this->notify($member, $mailer);//send a mail to member for confirm account
            $manager->persist($member);
            $manager->flush();

            $this->addFlash(
                'success',
                "La fiche de {$member->getPseudo()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('members_index');
        }

        return $this->render('member/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function notify(Member $member, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Activation de votre compte - Domain'))
            ->setFrom('bouchet.hp@gmail.com')
            ->setTo($member->getMail())
            ->setBody($this->renderView('message/emailValidation.html.twig', [
                'member' => $member
            ]), 'text/html');

        try {
            $mailer->send($message);
        }
        catch(\Exception $e) {

        }
    }

    /**
     * Modifier un Membre
     * @IsGranted("ROLE_ADMIN")
     * @Route("members/{pseudo}/edit", name="member_edit")
     *
     * @return Response
     */
    public function edit(Member $member, Request $request, ObjectManager $manager){
        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($member);
            $manager->flush();

            $this->addFlash(
                'success',
                "La fiche de {$member->getPseudo()} a bien été modifiée !"
            );

            return $this->redirectToRoute('members_index');
        }

        return $this->render('member/edit.html.twig',[
            'form' =>$form->createView()
        ]);
    }

    /**
     * Modifier ses données personnelle
     * @IsGranted("ROLE_USER")
     * @Route("members/modif", name="user_edit")
     *
     * @return Response
     */
    public function userEdit(Request $request, ObjectManager $manager){

        $user = $this->getUser();

        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre fiche a bien été modifiée !"
            );

            return $this->redirectToRoute('diving_listeDiving');
        }

        return $this->render('member/user_edit.html.twig',[
            'form' =>$form->createView()
        ]);
    }


    /**
     * Supprimer une membre
     *
     * @Route("/members/{pseudo}/delete", name="member_delete" )
     * @IsGranted("ROLE_ADMIN")
     * @param Member $member
     * @param ObjectManager $manager
     * @return Response
     *
     */
    public function delete(Member $member, ObjectManager $manager){
        $manager->remove($member);
        $manager->flush();

        $this->addFlash(
            'success',
            "La fiche de {$member->getPseudo()} a bien été supprimée !"
        );

        return $this->redirectToRoute("members_index");
    }



    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     *
     * @Route("/login", name="account_login")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * permet de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     * @return void
     */

    public function logout(){}


    /**
     * Affichage du menu Admin
     *
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function AdminMenu()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * Permet de modifier le mot de passe
     * @Route("/members/password-update", name="update_password")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
     public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager){
      $passwordUpdate = new PasswordUpdate();

      $user = $this->getUser();

      $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()){
           if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())){
                $form->get('oldPassword')->addError(new FormError('Il y a une erreur concernant votre mot de passe actuel !'));
           }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $password= $encoder->encodePassword($user, $newPassword);
                $user->setPassword($password);

               $manager->persist($user);
               $manager->flush();

               $this->addFlash(
                   'success',
                   "Votre mot de passe a bien étét modifié !"
               );
               return $this->redirectToRoute('diving_listeDiving');
           }
      }

      return $this->render('member/password.html.twig', [
          'form' =>$form->createView()
      ]);
     }

}
