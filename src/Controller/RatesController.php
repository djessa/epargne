<?php

namespace App\Controller;
use App\Entity\Rates;
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
            $data['result'] = $ratesRepository->findOneBy(['year' => $_POST['year'], 'month' => $_POST['month']]);
        }
        return $this->render('rates/index.html.twig', compact('data'));
    }

    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $rate = new Rates();
        $form = $this->createForm(RatesType::class, $rate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($rate);
            $entityManager->flush();
            return $this->redirectToRoute('rates');
        }
        return $this->render('rates/new.html.twig', ['form' => $form->createView(),]);
    }
}
