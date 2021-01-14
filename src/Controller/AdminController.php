<?php

namespace App\Controller;

use App\Entity\Rates;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        /*  if ($this->getUser() && $this->getUser()->getIsAdmin()) {
            return $this->render('security/admin.html.twig');
        } else {*/
        return new Response("C'est une page d'administration, Vous n'avez pas le droit d'accès");
        // }
    }
    /**
     * @Route("/init-project", name="add_admin")
     */
    public function addAdmin(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $admin  = new Users();
        $admin->setUsername('djessa');
        $admin->setPassword('admindjessa');
        $admin->setIsAdmin(true);
        $hash = $encoder->encodePassword($admin, $admin->getPassword());
        $admin->setPassword($hash);
        $em->persist($admin);
        $taux = new Rates();
        $taux->setYear(2021);
        $taux->setMonth('January');
        $taux->setValueOfOne(7.9);
        $taux->setValueOfTwo(9.6);
        $taux->setValueOfThree(10.7);
        $em->persist($taux);
        $em->flush();
        return new Response('Tout est réglé');
    }
}
