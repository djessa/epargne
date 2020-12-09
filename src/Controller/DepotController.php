<?php

namespace App\Controller;

use App\Entity\Corporations;
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
     * @Route("{id}/{id_morale}/depot", name="depot")
     */
    public function index(Persons $persons, $id_morale, DepotsRepository $depotsRepository): Response
    {
        $empty = false;
        $personel = true;
        $corporations = null;
        if ($id_morale != 0){
            $personel = false;
            $repo = $this->getDoctrine()->getRepository(Corporations::class);
            $corporations = $repo->find($id_morale);
        }
        $depots = $depotsRepository->findBy(['persons'=>$persons, 'corporations'=>$corporations]);
        if (empty($depots)){
            $empty = true;
        }
        return $this->render('depot/index.html.twig',
            [
                'persons'=>$persons,
                'depots'=>$depots,
                'empty'=>$empty,
                'corporations'=>$corporations ?? null,
                'personel'=>$personel
            ]
        );
    }
    /**
     * @Route("{id}/{id_morale}/depot/new", name="depot_new")
     */
    public function new(Persons $persons, $id_morale, Request $request, EntityManagerInterface $entityManager, RatesRepository $ratesRepository):Response
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
            if ($id_morale != 0){
                $repo = $this->getDoctrine()->getRepository(Corporations::class);
                $corporations = $repo->find($id_morale);
                $depot->setCorporations($corporations);
            }
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
