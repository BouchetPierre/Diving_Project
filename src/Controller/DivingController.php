<?php

namespace App\Controller;

use App\Entity\Diving;
use App\Entity\Member;
use App\Form\DivingType;
use App\Repository\DivingRepository;
use App\Repository\MemberRepository;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Reservation;

class DivingController extends AbstractController
{
    /**
     * Liste des plongées pour les administrateurs
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_USER")
     */
    public function liste(DivingRepository $repo, ReservationRepository $repoResa)
    {
        $diving = $repo->findAll();
        $id = $this->getUser()->getId();
        $reservations = $repoResa->findByUser($id);

        return $this->render('diving/listeDiving.html.twig', [
            'diving'=> $diving,
            'reservations'=>$reservations

        ]);
    }

    /**
     * Création d'une plongée
     *
     * @Route("/diving/new", name="diving_create")
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_USER")
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
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
     * @param Diving $diving
     * @param ObjectManager $manager
     * @param ReservationRepository $repo
     * @param \Swift_Mailer $mailer
     *
     * @return Response
     *
     */
    public function delete($id, Diving $diving, ObjectManager $manager, ReservationRepository $repo, \Swift_Mailer $mailer){

        $reservation = $repo->findMailMemberDiv($id);

        foreach($reservation as $key => $val){
            foreach ($val as $key2=> $val2){
                $this->notify($val2, $mailer, $id);//send a mail to member for notify cancellation
            }
        }
        $test = $diving->getLocation();


        $member = $repo->findDivMember($id);



        $manager->remove($diving);
        $manager->flush();

        $this->addFlash(
            'success',
            "La plongée à {$diving->getLocation()} a bien été supprimée !"
        );

        return $this->redirectToRoute("diving_index");
    }




    private function notify($mailMember, \Swift_Mailer $mailer, $id) //function to send a mail to member for notify cancellation
    {

        $message = (new \Swift_Message('Attention Annulation de plongée !!!'))
            ->setFrom('bouchet.hp@gmail.com')
            ->setTo($mailMember)
            ->setBody('Attention , nous avons dû annuler la plongée n°'.$id);

        try {
            $mailer->send($message);
        }
        catch(\Exception $e) {

        }
    }
}
