<?php

namespace App\Controller;

use App\Entity\Persons;
use App\Form\PersonsType;
use App\Repository\PersonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonController extends AbstractController
{

    private $em;
    private $persons;
    private $personsRepos;
    private $request;

    public function __construct(PersonsRepository $pr, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->personsRepos = $pr;
        $this->persons = $pr->findBy([], ['id' => 'DESC']);
        $this->request = Request::createFromGlobals();
    }
    /**
     * @Route ("/person", name="person")
     *
     */
    public function  index()
    {
        $persons = $this->persons;
        if (!empty($_GET['q'])) {
            $q = htmlentities($_GET['q']);
            if (is_numeric($q) && strlen($_GET['q']) == 12) {
                $persons = $this->personsRepos->findBy(['identity' => $q]);
            }
        }
        return $this->render('client/person/index.html.twig', compact('persons'));
    }
    /**
     * @Route("/person/register", name="person_register")
     */
    public function register(): Response
    {
        $person = new Persons();
        $person_form = $this->createForm(PersonsType::class, $person);
        $person_form->handleRequest($this->request);
        if ($person_form->isSubmitted() && $person_form->isValid()) {
            $this->em->persist($person);
            $this->em->flush();
            $this->addFlash('success', 'Une personne a bien été inscrit avec succès');
            return $this->redirectToRoute('person');
        }
        return $this->render('client/person/register.html.twig', [ 'form' => $person_form->createView()]);
    }
    /**
     * @Route("/person/show/{id}", name="person_show")
     */
    public function show(Persons $persons)
    {
        return $this->render('client/person/show.html.twig', compact('persons'));
    }
}
