<?php

namespace App\Controller;

use App\Entity\Diving;
use App\Form\DivingType;
use App\Repository\DivingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DivingController extends AbstractController
{
    /**
     * Liste des plongées
     *
     * @Route("/diving", name="diving_index")
     */
    public function index(DivingRepository $repo)
    {
        $diving = $repo->findAll();

        return $this->render('diving/index.html.twig', [
            'diving'=> $diving,
        ]);
    }

    /**
     * Création d'une plongée
     *
     * @Route("/diving/new", name="diving_create")
     *
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager){
        $diving = new Diving();

        $form = $this->createForm(DivingType::class, $diving);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($diving);
            $manager->flush();

            $this->addFlash(
                'success',
                "La plongée à {$diving->getLocation()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('diving_index');
        }

        return $this->render('diving/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
