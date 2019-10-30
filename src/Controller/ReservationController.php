<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Reservation;
use App\Entity\Diving;
use App\Form\MemberType;
use App\Form\ReservationType;
use App\Repository\DivingRepository;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use \Exception;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReservationController extends AbstractController
{
    /**
     * Voir les détails d'une plongée et valider sa participation
     * @IsGranted("ROLE_USER")
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

                $diving->setPlaceResa(($diving->getPlaceResa())+1);
                $reservation->setFkIdMember($user)
                            ->setFkIdDiving($diving);
                $user->setTicketDive(($user->getTicketDive())-1);

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
     * @ISGranted("ROLE_USER")
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
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function show($id, ReservationRepository $repo){
        $reservation = $repo->findDivMember($id);
        $nbMember=count($repo->findDivMember($id));

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'nbMember' => $nbMember

        ]);
    }

    /**
     * Supprimer une reservation
     *
     * @Route("/reservations/{id}/delete", name="reservation_delete" )
     * @IsGranted("ROLE_ADMIN")
     * @param Reservation $reservation
     * @param ObjectManager $manager
     * @return Response
     *
     */
    public function delete(Reservation $reservation, ObjectManager $manager)
    {
        $reservation->getFkIdDiving()->setPlaceResa(($reservation->getFkIdDiving()->getPlaceResa()-1));

        $manager->remove($reservation);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre réservation a été annulée"
        );

        return $this->redirectToRoute("diving_listeDiving");
    }

    /**
     * Imprimer un pdf de la liste de palanquée
     *
     * @Route("listeDiving/reservation/pdf/{id}", name="liste_palanquee")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function print($id, ReservationRepository $repo, DivingRepository $repoDive){

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $reservation = $repo->findDivMember($id);
        $numDive[]=$id;
        $infoDive=$repoDive->findById($id);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation/listePalanquee.html.twig', [
            'reservation' => $reservation,
            'numDive' => $numDive,
            'infoDive' => $infoDive
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);

    }
}