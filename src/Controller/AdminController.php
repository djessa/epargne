<?php

namespace App\Controller;

use App\Entity\Corporations;
use App\Entity\Persons;
use App\Entity\Rates;
use App\Form\RatesType;
use App\Repository\RatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/rate", name="admin_rate")
     */
    public function rate(RatesRepository $ratesRepository):Response
    {
        $data['current'] = $ratesRepository->findOneBy(['year' => getdate()['year'], 'month' => getdate()['month']]);
        if (isset($_POST['year'], $_POST['month'])) {
            $data['result'] = $ratesRepository->findOneBy(['year' => $_POST['year'], 'month' => $_POST['month']]);
        }
        return $this->render('admin/rate.html.twig', compact('data'));
    }
    /**
     * @Route("/admin/rate/new", name="admin_rate_new")
     * ajouter une nouvel taux
     */
    public function new_rate(EntityManagerInterface $entityManager, Request $request): Response
    {
        $rate = new Rates();
        $form = $this->createForm(RatesType::class, $rate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($rate);
            $entityManager->flush();
            return $this->redirectToRoute('admin_rate');
        }
        return $this->render('admin/new_rate.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
