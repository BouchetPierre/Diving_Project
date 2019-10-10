<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Reservation;
use App\Entity\Diving;
use App\Form\MemberType;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use \Exception;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ReservationController extends AbstractController
{
    /**
     * Voir les détails d'une plongée et valider sa participation
     *
     * @Route("/diving/{id}/reservation", name="reservation_create")
     * @return Response
     */
    public function reservation(Diving $diving, Request $request, ObjectManager $manager)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            try {
                $reservation->setFkIdMember($user)
                            ->setFkIdDiving($diving);

                $manager->persist($reservation);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "La réservation a été ajoutée à votre planning !"
                );
            }catch(Exception $e){
                $this->addFlash(
                    'danger',
                    "Vous avez déjà réservé cette plongée"
                );
            };
            return $this->redirectToRoute('diving_listeDiving', ['id' => $reservation->getId()]);
        }

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'diving' => $diving
        ]);
    }

    /**
     * Permet d'afficher les plongées en fonction du user
     *
     * @Route ("members/reservations/{id}", name="member_reservation")
     *
     * @return Response
     */
    public function Reservations($id, ReservationRepository $repo)
    {
        $reservations = $repo->findByUser($id);

        return $this->render('member/reservations.html.twig', [
            'reservations' => $reservations
        ]);
    }

    /**
     * Affiche les participants à une plongée
     *
     * @Route("listeDiving/reservation/{id}", name="reservation_div_members")
     *
     * @return Response
     */
    public function show($id, ReservationRepository $repo){
        $reservation = $repo->findDivMember($id);

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation
        ]);
    }

    /**
     * Supprimer une reservation
     *
     * @Route("/reservations/{id}/delete", name="reservation_delete" )
     *
     * @param Reservation $reservation
     * @param ObjectManager $manager
     * @return Response
     *
     */
    public function delete(Reservation $reservation, ObjectManager $manager)
    {
        $manager->remove($reservation);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre réservation a été annulée"
        );

        return $this->redirectToRoute("diving_listeDiving");
    }
}