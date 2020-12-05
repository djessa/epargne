<?php

namespace App\Controller;

use App\Entity\Depots;
use App\Entity\Funds;
use App\Entity\Persons;
use App\Form\FundsType;
use App\Repository\DepotsRepository;
use App\Repository\RatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepotController extends AbstractController
{
    /**
     * @Route("{id}/depot", name="depot")
     */
    public function index(Persons $persons, DepotsRepository $depotsRepository): Response
    {
        $depots = $depotsRepository->findBy(['persons'=>$persons]);
        $empty = false;
        if (empty($depots)){
            $empty = true;
        }
        return $this->render('depot/index.html.twig',
            ['persons'=>$persons, 'depots'=>$depots, 'empty'=>$empty]
        );
    }
    /**
     * @Route("{id}/depot/new", name="depot_new")
     */
    public function new(Persons $persons, Request $request, EntityManagerInterface $entityManager, RatesRepository $ratesRepository):Response
    {
        $date = getdate();
        $rate = $ratesRepository->findBy(['month'=>$date['month']]);
        $fund = new Funds();
        $form = $this->createForm(FundsType::class, $fund);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $fund->setRate($rate[0]);
            $depot = new Depots();
            $depot->setCreatedAt(new \DateTime());
            $depot->setFund($fund);
            $depot->setPersons($persons);
            $entityManager->persist($fund);
            $entityManager->persist($depot);
            $entityManager->flush();
            return $this->render('depot/new.html.twig',
                ['success'=>'Un fond a bien été déposé']
            );
        }
        return $this->render('depot/new.html.twig',
            ['form'=>$form->createView()]
        );
    }
}
