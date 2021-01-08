<?php

namespace App\Controller;

use App\Entity\Rates;
use App\Form\RatesType;
use App\Repository\RatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RatesController extends AbstractController
{
    /**
     * @Route("/rates", name="rates")
     */
    public function index(RatesRepository $ratesRepository): Response
    {
        $data['current'] = $ratesRepository->findOneBy(['year' => getdate()['year'], 'month' => getdate()['month']]);
        if (isset($_POST['year'], $_POST['month'])) {
            $result = $ratesRepository->findOneBy(['year' => $_POST['year'], 'month' => $_POST['month']]);
            if ($result) {
                $data['result'] = $result;
            } else {
                $data['error'] = "Il n'y aucune taux pour cette periode";
            }
        }
        return $this->render('services/rates/index.html.twig', ['data' => $data, 'rates_nav' => true]);
    }

    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        if (!($this->getUser() && $this->getUser()->getIsAdmin())) {
            return new Response("C'est une page d'administration, Vous n'avez pas le droit d'accès");
        }
        $rate = new Rates();
        $form = $this->createForm(RatesType::class, $rate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rate);
            $entityManager->flush();
            return $this->redirectToRoute('rates');
        }
        return $this->render('services/rates/new.html.twig', ['form' => $form->createView(), 'rates_nav' => true]);
    }
}
