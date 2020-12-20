<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends AbstractController
{

    public function login(): Response
    {
        return $this->render('users/login.html.twig');
    }
    public function logout(): Response
    {
        return $this->render('users/login.html.twig');
    }
}
