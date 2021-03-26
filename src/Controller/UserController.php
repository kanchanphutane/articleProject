<?php

namespace App\Controller;

use App\Document\User;
use App\Form\UserForm;
use App\Service\apiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use FOS\RestBundle\Controller\Annotations as Rest;


class UserController extends AbstractController
{

    public $session;
    private $client;

    public function __construct(SessionInterface $session,HttpClientInterface $client)
    {
        $this->session = $session;
        $this->client = $client;

    }

    /**
     * @Route("/user", name="user", methods={"GET","POST"})
     */
    public function index(DocumentManager $dm)
    {
        $myUsers = $dm->createQueryBuilder(User::class)
                 ->getQuery();

        $firstname = $this->get('session')->get('firstname');

        return $this->render('user/index.html.twig', [
            'user' => $myUsers,
            'firstname' => $firstname,  

        ]);
    }

    /**
     * @Route("/userIndex", name="userIndex", methods={"GET","POST"})
     */
    public function userIndex(DocumentManager $dm)
    {
        $myUsers = $dm->createQueryBuilder(User::class)
                 ->getQuery();

        $firstname = $this->get('session')->get('firstname');

        return $this->render('user/userIndex.html.twig', [
            'user' => $myUsers,
            'firstname' => $firstname,  

        ]);
    }

    // /**
    //  * @Route("/user/register", name="registerPage", methods={"GET","POST"})
    //  */
    // public function register(DocumentManager $dm,Request $request)
    // {
    //     $user = new User();
    //     $form = $this->createForm(UserForm::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) 
    //     {
    //         $data = $form->getData();
	// 		$dm->persist($data);
    //         $dm->flush();
    //         $request->getSession()
    //                 ->getFlashBag()
    //                 ->add('success', 'Great! User has been added succesfully!!!');
            
    //         // Redirect to your specific file
    //         return $this->redirectToRoute('login');
    //         }
    //     return $this->render('user/register.html.twig',[
    //         'form' => $form->createView(), 
    //     ]);    
    // }

    //methods={"GET","POST"}
    /**
     * @Route("/user/login", name="login")
     */
    public function login(DocumentManager $dm, Request $request)
    {
        $error = '';
        // AuthenticationUtils $authenticationUtils
        // // get the login error if there is one
        //  $error = $authenticationUtils->getLastAuthenticationError();
        // // last username entered by the user
        // $lastUsername = $authenticationUtils->getLastUsername();

        if($this->session->get('logged_in')){
            // $error = 'You are already logged in';
            $this->session->getFlashBag()->add('info', 'You are already logged in! Logout first..');
            return $this->redirectToRoute('user');
        }
        if($request->isMethod('post'))
        {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
        
                // $user = $dm->getRepository(User::class)->find($email);
                $user = $dm->createQueryBuilder(User::class)
                ->field('email')->equals($email)
                ->field('password')->equals(md5($password))
                ->field('usertype')->equals('1')
                ->getQuery()
                ->getSingleResult();

                $admin = $dm->createQueryBuilder(User::class)
                ->field('email')->equals($email)
                ->field('password')->equals(md5($password))
                ->field('usertype')->equals('0')
                ->getQuery()
                ->getSingleResult();

                if($user){
                    $this->session->set('logged_in','yes');
                    $this->session->set('user_id', $user->getId());
                    $this->session->set('firstname', $user->getFirstname());
                
                        $this->session->getFlashBag()->add('success', 'User logged in successfully!');
                        return $this->redirectToRoute('userIndex');
                        // articleListingPage
                }elseif($admin){
                    $this->session->set('logged_in','yes');
                    $this->session->set('user_id', $admin->getId());
                    $this->session->set('firstname', $admin->getFirstname());

                    $this->session->getFlashBag()->add('success', 'Admin logged in successfully!Welcome to Admin Panel!!');
                    return $this->redirectToRoute('user');
                    // articlePage
                }else{

                    $this->session->getFlashBag()->add('danger', 'User does not exist!');
                    return $this->redirectToRoute('login');
                }
                
        }
   
        return $this->render('user/login.html.twig',[
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        $this->session->set('logged_in','no');
        // $request->getSession()->invalidate();
        $request->getSession()->clear();
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/usermanagement", name="usermanagement", methods={"GET","POST"})
     */
    public function userManagement(DocumentManager $dm)
    {
        $myUsers = $dm->createQueryBuilder(User::class)
                        ->limit(10)
                        ->skip(0)
                        ->getQuery()
                        ->execute();

        // user/
        return $this->render('user/usermanagement.html.twig', [
            'user' => $myUsers

        ]);
    }


    // /**
    //  * @Route("/usermanagement/delete/{id}", name="deleteUser")
    //  */
    // public function deleteUser(DocumentManager $dm,$id)
    // {
    //     $user = $dm->find(User::class, $id);
    //     if($user){
    //         $dm->remove($user);
    //         $dm->flush();
            
    //         $this->addFlash('danger', 'You deleted a User');
            
    //     }else{
    //         throw $this->createNotFoundException(
    //             'No id found as ' . $id
    //             );
    //     }
    //     return $this->redirectToRoute('usermanagement');
    // }

    // /**
    // * @Rest\Get("/edit/{id}", name="editUser")
    // */

    // //  /** 
    // //  * @Route("/usermanagement/edit/{id}", name="editUser")
    // //  **/
    // public function update(DocumentManager $dm,Request $request, $id)
    // {
    //     $user = $dm->find(User::class, $id);

    //     $form = $this->createForm(UserForm::class, $user, ['method'=>'PUT']);
    //     $form->handleRequest($request);

        
	// 	 if ($form->isSubmitted()) {

    //         $response = $this->client->request(
    //             'GET',
    //             'https://'
    //         );

    //         // $data = $form->getData();
    //         ;$data = $response->getContent();
	// 		$dm->persist($data);
    //         $dm->flush();
    //         $request->getSession()
    //                 ->getFlashBag()
    //                 ->add('info', 'User has been updated succesfully!!!');
            
    //         return $this->redirectToRoute('usermanagement');
    //     }

    //     return $this->render('user/edituser.html.twig', [
    //         'form' => $form->createView(), 
    //     ]);
    // }


    

}
