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
        if ($this->getUser() && $this->getUser()->getIsAdmin()) {
            return $this->render('security/admin.html.twig');
        } else {
            return new Response("C'est une page d'administration, Vous n'avez pas le droit d'accès");
        }
    }
}
