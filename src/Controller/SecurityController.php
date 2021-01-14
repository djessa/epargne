<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function index(Request $request, EntityManagerInterface $objectManager, UserPasswordEncoderInterface $encoder): Response
    {
        if (!($this->getUser() && $this->getUser()->getIsAdmin())) {
            return new Response("C'est une page d'administration, Vous n'avez pas le droit d'accès");
        }
        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $objectManager->persist($user);
            $objectManager->flush();
            $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/login", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }
}
