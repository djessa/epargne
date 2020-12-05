<?php

namespace App\Controller;

use App\Entity\Rates;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/admin/rate/new", name="admin_rate_new")
     */
    public function new_rate(EntityManagerInterface $entityManager): Response
    {
        $rate = new Rates();
        $rate->setYear(2020)
            ->setMonth('december')
            ->setValueOfOne(8.6)
            ->setValueOfTwo(10.2)
            ->setValueOfThree(11.3);
        $entityManager->persist($rate);
        $entityManager->flush();
        dd($rate);
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
