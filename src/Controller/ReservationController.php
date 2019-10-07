<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Reservation;
use App\Form\MemberType;
use App\Form\ReservationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ReservationController extends AbstractController
{
    /**
     * Voir les détails d'un plongée et valider sa participation
     * @Route("/reservation", name="reservation")
     * @return Response
     */
    public function validation(Request $request, ObjectManager $manager)
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($reservation);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre réservation a été prise en compte !"
            );

            return $this->redirectToRoute('diving_listeDiving');
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

