<?php

namespace App\Controller;

use App\Entity\Persons;
use App\Form\PersonsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class PersonController extends AbstractController
{
    /**
     * @Route ("/person", name="person")
     *
     */
    public function  index()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }
        //Recupération de liste des personnes et on passe à la vue avec des opérations concérnés
        $persons = $this->getDoctrine()->getRepository(Persons::class)->findBy([], ['id' => 'desc']);
        //S'il y a une recherche effectué sur la page 
        if (!empty($_GET['q'])) {
            $q = htmlentities($_GET['q']);
            if (is_numeric($q) && strlen($_GET['q']) == 12) {
                $persons = $this->getDoctrine()->getRepository(Persons::class)->findBy(['identity' => $q]);
            }
        }
        return $this->render('client/person/index.html.twig', ['persons' => $persons, 'person_nav' => true]);
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
            return $this->redirectToRoute('person');
        }
        return $this->render('client/person/register.html.twig', [
            'form' => $person_form->createView(),
            'person_nav' => true
        ]);
    }
    /**
     * @Route("/{id}/person/show", name="person_show")
     */
    public function show(Persons $persons)
    {
        return $this->render('client/person/show.html.twig', ['persons' => $persons, 'person_nav' => true]);
    }
}
