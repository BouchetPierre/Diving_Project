<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

}
