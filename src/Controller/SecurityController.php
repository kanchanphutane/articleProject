<?php

namespace App\Controller;

use App\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/user/security/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

            // if ($this->getUser()) {
            //     if( in_array('admin', $this->getUser()->getUsertype() ) ):
            //         return $this->redirectToRoute('article');
            //     elseif ( in_array('user', $this->getUser()->getUsertype() ) ):
            //         return $this->redirectToRoute('userIndex');
            //     else:
            //         return $this->redirectToRoute('app_login');
            //     endif;
            // }
       

            // $session = new Session();
            // $session->set('name','admin');
            // $user = $session->get('name');

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            // 'user' => $user
        ]);

    }

    /**
     * @Route("/log", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


}
