<?php

namespace App\Controller;

use App\Entity\Diving;
use App\Form\DivingType;
use App\Repository\DivingRepository;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DivingController extends AbstractController
{
    /**
     * Liste des plongées pour les administrateurs
     *
     * @Route("/diving", name="diving_index")
     */
    public function index(DivingRepository $repo)
    {
        $diving = $repo->findAll();
        $nbDiving=count($diving);
        $tabNbDiving[]=$nbDiving;

        return $this->render('diving/index.html.twig', [
            'diving'=> $diving,
            'tabNbDiving' => $tabNbDiving
        ]);
    }


    /**
     * Liste des plongées
     *
     * @Route("/listeDiving", name="diving_listeDiving")
     */
    public function liste(DivingRepository $repo, ReservationRepository $nbPlce)
    {
        $diving = $repo->findAll();
        $nbplace = $nbPlce->findNbPlaceDiv();
        var_dump($nbplace);

        return $this->render('diving/listeDiving.html.twig', [
            'diving'=> $diving,
            'nbplace' => $nbplace
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

    /**
     * Affiche une plongée
     *
     * @Route("listediving/{id}", name="listediving_show")
     *
     * @return Response
     */
    public function show($id, DivingRepository $repo){
        $diving = $repo->findOneById($id);

        return $this->render('diving/show.html.twig', [
            'diving' => $diving
        ]);
    }

    /**
     * Modifier une plongée
     *
     * @Route("diving/{id}/edit", name="diving_edit")
     *
     * @return Response
     */
    public function edit(Diving $diving, Request $request, ObjectManager $manager){
        $form = $this->createForm(DivingType::class, $diving);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($diving);
            $manager->flush();

            $this->addFlash(
                'success',
                "La plongée n° {$diving->getId()} a bien été modifiée !"
            );

            return $this->redirectToRoute('diving_index');
        }

        return $this->render('diving/edit.html.twig',[
            'form' =>$form->createView()
            ]);
    }

    /**
     * Supprimer une plongée
     *
     * @Route("/diving/{id}/delete", name="diving_delete" )
     *
     * @param Diving $diving
     * @param ObjectManager $manager
     * @return Response
     *
     */
    public function delete(Diving $diving, ObjectManager $manager){
        $manager->remove($diving);
        $manager->flush();

        $this->addFlash(
            'success',
            "La plongée à {$diving->getLocation()} a bien été supprimée !"
        );

        return $this->redirectToRoute("diving_index");
    }
}
