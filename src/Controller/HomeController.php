<?php

namespace App\Controller;

use App\Entity\Rates;
use App\Entity\Users;
use App\Repository\RatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    public  function index(RatesRepository $rates, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        // on va recuperer le taux courant 
        $taux = $rates->findOneBy(['month' => getdate()['month'], 'year' => getdate()['year']]);
        if(!$taux) {
            $taux = new Rates();
            $taux->setValueOfOne(8.9);
            $taux->setValueOfTwo(11.2);
            $taux->setValueOfThree(12.5);
            $taux->setYear(getdate()['month']);
            $taux->setMonth(getdate()['year']);
            $em->persist($taux);
            $user = new Users();
            $user->setUsername('admin');
            $user->setPassword($encoder->encodePassword($user, 'adminadmin'));
            $em->persist($user);
            $em->flush();
        }
        return $this->render('services/home/home.html.twig', ['taux' => $taux]);
    }
}
