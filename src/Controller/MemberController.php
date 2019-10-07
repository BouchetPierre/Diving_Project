<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class MemberController extends AbstractController
{
    /**
     * Liste des membres
     *
     * @Route("/members", name="members_index")
     */
    public function index(MemberRepository $repo)
    {
        $members = $repo->findAll();

        return $this->render('member/index.html.twig', [
            'members'=> $members,
        ]);
    }

    /**
     * Création d'un membre
     *
     * @Route("/members/new", name="members_create")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password= $encoder->encodePassword($member, $member->getPassword());
            $member->setPassword($password);
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

    /**
     * Affiche un membre
     *
     * @Route("members/{pseudo}", name="member_show")
     *
     * @return Response
     */
    public function show($pseudo, MemberRepository $repo){
        $member = $repo->findOneByPseudo($pseudo);

        return $this->render('member/show.html.twig', [
            'member' => $member
        ]);
    }

    /**
     * Modifier un Membre
     *
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
     * Supprimer une membre
     *
     * @Route("/members/{pseudo}/delete", name="member_delete" )
     *
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


}
