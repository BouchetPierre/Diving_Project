<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DivingController extends AbstractController
{
    /**
     * @Route("/diving", name="diving")
     */
    public function index()
    {
        return $this->render('diving/index.html.twig', [
            'controller_name' => 'DivingController',
        ]);
    }
}
