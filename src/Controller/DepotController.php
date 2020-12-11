<?php

namespace App\Controller;

use App\Entity\Corporations;
use App\Entity\Depots;
use App\Entity\Funds;
use App\Entity\Persons;
use App\Entity\Retraits;
use App\Form\FundsType;
use App\Repository\DepotsRepository;
use App\Repository\RatesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepotController extends AbstractController
{
    /**
     * @Route("{id}/{id_morale}/depot", name="depot")
     */
    public function index(Persons $persons, $id_morale, DepotsRepository $depotsRepository): Response
    {
        $proprietaire = [];
        $proprietaire['name'] = $persons->getName();
        $proprietaire['id'] = $persons->getId();
        $proprietaire['corporation'] = 0;
        $corporations = null;
        if ($id_morale != 0) {
            $corporations = $this->getDoctrine()->getRepository(Corporations::class)->find($id_morale);
            $proprietaire['name'] = $corporations->getSocialReason();
            $proprietaire['corporation'] = $corporations->getId();
        }
        $depots = $depotsRepository->findBy(['persons' => $persons, 'corporations' => $corporations]);
        if (empty($depots)) {
            return $this->render(
                'depot/index.html.twig',
                [
                    'empty' => true,
                    'proprietaire' => $proprietaire
                ]
            );
        }
        return $this->render(
            'depot/index.html.twig',
            [
                'proprietaire' => $proprietaire,
                'depots' => $depots,
            ]
        );
    }
    /**
     * @Route("{id}/{id_morale}/depot/new", name="depot_new")
     */
    public function new(Persons $persons, $id_morale, Request $request, EntityManagerInterface $entityManager, RatesRepository $ratesRepository): Response
    {
        $date = getdate();
        $rate = $ratesRepository->findBy(['month' => $date['month']]);
        $fund = new Funds();
        $form = $this->createForm(FundsType::class, $fund);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fund->setRate($rate[0]);
            $depot = new Depots();
            $depot->setCreatedAt(new \DateTime());
            $depot->setFund($fund);
            $depot->setPersons($persons);
            if ($id_morale != 0) {
                $repo = $this->getDoctrine()->getRepository(Corporations::class);
                $corporations = $repo->find($id_morale);
                $depot->setCorporations($corporations);
            }
            $entityManager->persist($fund);
            $entityManager->persist($depot);
            $entityManager->flush();
            return $this->redirectToRoute('depot', ['id' => $persons->getId(), 'id_morale' => $id_morale]);
        }
        $proprietaire = [];
        $proprietaire['name'] = $persons->getName();
        $proprietaire['id'] = $persons->getId();
        $proprietaire['corporation'] = 0;
        $repo = $this->getDoctrine()->getRepository(Corporations::class);
        if ($id_morale != 0) {
            $corporations = $repo->find($id_morale);
            $proprietaire['corporation'] = $corporations->getId();
            $proprietaire['name'] = $corporations->getSocialReason();
        }
        return $this->render(
            'depot/new.html.twig',
            ['form' => $form->createView(), 'proprietaire' => $proprietaire]
        );
    }
    /**
     * @Route("/{id}/remove", name="remove")
     */
    public function remove(Depots $depots, EntityManagerInterface $entityManagerInterface, Request $request)
    {
        if (!empty($_POST['person_id'])) {
            $year =  (int)$depots->getCreatedAt()->format('Y');
            $month =  (int) $depots->getCreatedAt()->format('m');
            $day = (int)$depots->getCreatedAt()->format('d');
            $time = mktime(null, null, null, $month, $day, $year);
            $fund = $depots->getFund();
            $time += $fund->getDuration() * 365 * 24 * 60 * 60 + 24 * 60 * 60;
            if (time() < $time) {
                $date = date('d/m/Y', $time);
                return $this->render('depot/error.html.twig', ['message' => 'Cette caisse ne peut pas être rétirer selon le contrat , notament sur le delai', 'date' => $date]);
            }
            $retrait = new Retraits();
            $retrait->setCreatedAt(new \DateTime());
            $retrait->setFund($fund);
            $retrait->setPerson($depots->getPersons());
            $entityManagerInterface->persist($retrait);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('person');
        }
        return $this->render('depot/retrait.html.twig', compact('depots'));
    }
}
