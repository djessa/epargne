<?php
namespace App\Controller;

use App\Entity\Persons;
use App\Entity\Corporations;
use App\Form\CorporationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CorporationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class CorporationController extends AbstractController
{
    /**
     * @Route("/{id}/corporation", name="corporation")
     */
    public  function  index(Persons $persons, CorporationsRepository $corporationsRepository): Response
    {
        return $this->render('corporation/index.html.twig', [
            'persons' => $persons, 
            'person_nav' =>true, 
            'corporations' => $corporationsRepository->findBy(['person' => $persons], ['id' => 'desc'])
        ]);
    }
    /**
     * @Route("/{id}/corporation/register", name="corporation_register")
     */
    public  function  register(Persons $persons, Request $request, EntityManagerInterface $entityManager): Response
    {
        $corporation = new Corporations();
        $form = $this->createForm(CorporationsType::class, $corporation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $corporation->setPerson($persons);
            $entityManager->persist($corporation);
            $entityManager->flush();
            return $this->redirectToRoute('corporation', ['id' => $persons->getId(), 'id_morale' => $corporation->getId()]);
        }
        return $this->render('corporation/register.html.twig', [
            'form' => $form->createView(),
            'persons' => $persons
        ]);
    }
}