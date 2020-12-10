<?php

namespace App\Controller;

use App\Entity\Corporations;
use App\Entity\Persons;
use App\Form\CorporationsType;
use App\Form\PersonsType;
use App\Repository\CorporationsRepository;
use App\Repository\PersonRepository;
use App\Repository\PersonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route ("/", name="person")
     */
    public function  index(PersonsRepository $personRepository)
    {
        $persons = $personRepository->findAll();
        if (empty($persons)) {
            $empty = true;
            return $this->render('person/index.html.twig', compact('empty'));
        }
        return $this->render('person/index.html.twig', compact('persons'));
    }
    /**
     * @Route("/person/register", name="person_register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $person = new Persons();
        $person_form = $this->createForm(PersonsType::class, $person);
        $person_form->handleRequest($request);
        if ($person_form->isSubmitted() && $person_form->isValid()) {
            $entityManager->persist($person);
            $entityManager->flush();
            return $this->render('person/register.html.twig', [
                'success' => 'Une personne a bien été enregistré avec succès'
            ]);
        }
        return $this->render('person/register.html.twig', [
            'form' => $person_form->createView()
        ]);
    }
    /**
     * @Route("/{id}/corporation", name="person_corporation")
     */
    public  function  corporation(Persons $persons, CorporationsRepository $corporationsRepository): Response
    {
        $corporations = $corporationsRepository->findBy(['person' => $persons]);
        $empty = false;
        if (empty($corporations)) {
            $empty = true;
        }
        return $this->render('person/corporations.html.twig', ['persons' => $persons, 'corporations' => $corporations, 'empty' => $empty]);
    }
    /**
     * @Route("/{id}/corporation/register", name="person_corporation_register")
     */
    public  function  corporation_register(Persons $persons, Request $request, EntityManagerInterface $entityManager): Response
    {
        $corporation = new Corporations();
        $form = $this->createForm(CorporationsType::class, $corporation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $corporation->setPerson($persons);
            $entityManager->persist($corporation);
            $entityManager->flush();
            return $this->render('person/corporation_register.html.twig', [
                'success' => 'Une personne morale a bien été enregistré avec succès'
            ]);
        }
        return $this->render('person/corporation_register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/{id}/person/show", name="show")
     */
    public function show(Persons $persons)
    {
        return $this->render('person/show.html.twig', compact('persons'));
    }
}
