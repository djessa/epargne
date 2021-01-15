<?php

namespace App\Controller;

use App\Entity\Corporations;
use App\Entity\Depots;
use App\Entity\Funds;
use App\Entity\Persons;
use App\Entity\Rates;
use App\Entity\Retraits;
use App\Form\FundsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Dompdf\Dompdf;
use Dompdf\Options;

class DepotController extends AbstractController
{
    /**
     * @Route("{id}/{id_morale}/depot", name="depot")
     */
    public function index(Persons $persons, $id_morale): Response
    {
        return $this->render(
            'services/depot/index.html.twig',
            [
                'proprietaire' => $this->proprietaire($persons, $id_morale),
                'depots' => $this->getDoctrine()->getRepository(Depots::class)->findBy(['persons' => $persons, 'corporations' => $this->proprietaire($persons, $id_morale)['corporations']], ['id' => 'desc'])
            ]
        );
    }
    /**
     * @Route("{id}/{id_morale}/depot/new", name="depot_new")
     */
    public function new(Persons $persons, $id_morale, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($id_morale == 0)
            $depots = $this->getDoctrine()->getRepository(Depots::class)->findBy(['persons' => $persons], ['id' => 'desc']);
        else
            $depots =  $this->getDoctrine()->getRepository(Depots::class)->findBy(['corporations' => $this->getDoctrine()->getRepository(Corporations::class)->findOneBy(['id' => $id_morale])], ['id' => 'desc']);
        if (!empty($depots)) {
            $date_depots = $depots[0]->getCreatedAt();
            if ($date_depots->format('Y') == getdate()['year'] && $date_depots->format('m') == getdate()['mon'] && $date_depots->format('d') == getdate()['mday']) {
                return new Response("<script>alert('Un client ne peut déposer qu\'une seule fois dans une journée');</script>");
            }
        }
        $fund = new Funds();
        $form = $this->createForm(FundsType::class, $fund);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fund->setRate($this->getDoctrine()->getRepository(Rates::class)->findOneBy(['month' => getdate()['month'], 'year' => getdate()['year']]));
            $depot = new Depots();
            $depot->setCreatedAt(new \DateTime());
            $depot->setEndDate(new \DateTime(date('Y-m-d H:m:s', time() + $fund->getDuration() * 365 * 24 * 60 * 60 + 24 * 60 * 60)));
            $depot->setFund($fund);
            $depot->setPersons($persons);
            if ($id_morale != 0) {
                $corporations = $this->getDoctrine()->getRepository(Corporations::class)->find($id_morale);
                $depot->setCorporations($corporations);
            }
            $entityManager->persist($fund);
            $entityManager->persist($depot);
            $entityManager->flush();
            return $this->redirectToRoute('depot', [
                'id' => $persons->getId(),
                'id_morale' => $id_morale
            ]);
        }
        return $this->render(
            'services/depot/new.html.twig',
            ['form' => $form->createView(), 'proprietaire' => $this->proprietaire($persons, $id_morale)]
        );
    }
    /**
     * @Route("/{id}/remove", name="remove")
     */
    public function remove(Depots $depots, EntityManagerInterface $entityManagerInterface, Request $request)
    {
        $time = mktime(null, null, null, (int) $depots->getEndDate()->format('m'), (int)$depots->getEndDate()->format('d'), (int)$depots->getEndDate()->format('Y'));
        if (time() < $time) {
            $date = date('d/m/Y', $time);
            return $this->render('services/depot/error.html.twig', ['message' => 'Cette caisse ne peut pas être rétirer selon le contrat.', 'date' => $date]);
        }
        if (!empty($_POST['person_id'])) {
            $retrait = new Retraits();
            $retrait->setCreatedAt(new \DateTime());
            $retrait->setFund($depots->getFund());
            $persons = $this->getDoctrine()->getRepository(Persons::class)->findOneBy(['identity' => $_POST['person_id']]);
            if (!$persons) {
                return $this->render('services/depot/error.html.twig', ['message' => 'Cette personne doit s\'inscrire parce qu\'il n\'est pas connu']);
            }
            $retrait->setPerson($persons);
            $depots->setIsRetired(true);
            $entityManagerInterface->persist($retrait);
            $entityManagerInterface->flush();
            return $this->redirectToRoute(
                'depot',
                [
                    'id' => $depots->getPersons()->getId(),
                    'id_morale' => ($depots->getCorporations() != null) ? $depots->getCorporations()->getId() : 0
                ]
            );
        }
        return $this->render('services/retrait/new.html.twig', compact('depots'));
    }
    /**
     * @Route("/retrait/{fund}", name="show_retrait")
     */
    public function show_retrait(Retraits $retraits)
    {
        return $this->render('services/retrait/show.html.twig', compact('retraits'));
    }
    public function proprietaire($persons, $id_morale)
    {
        $proprietaire = [];
        $proprietaire['name'] = $persons->getName();
        $proprietaire['id'] = $persons->getId();
        $proprietaire['corporation'] = 0;
        $proprietaire['corporations'] = null;
        if ($id_morale != 0) {
            $corporations = $this->getDoctrine()->getRepository(Corporations::class)->find($id_morale);
            $proprietaire['corporations'] = $corporations;
            $proprietaire['name'] = $corporations->getSocialReason();
            $proprietaire['corporation'] = $corporations->getId();
        }
        return $proprietaire;
    }
    /**
     * @Route("/dompdf", name="dompdf")
     */
    public function dompdf()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('layout/contrat.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }
}
