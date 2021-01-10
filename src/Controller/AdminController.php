<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
