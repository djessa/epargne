<?php

namespace App\Controller;

use App\Entity\Rates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public  function index(): Response
    {
        return $this->render('services/home/home.html.twig', ['taux' => $this->getDoctrine()->getRepository(Rates::class)->findOneBy(['month' => getdate()['month'], 'year' => getdate()['year']])]);
    }
}
