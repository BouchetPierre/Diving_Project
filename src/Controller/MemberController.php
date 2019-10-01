<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MemberController extends AbstractController
{
    /**
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
     *@Route("/logout", name="account_logout")
     * @return void
     */

    public function logout(){}
}
