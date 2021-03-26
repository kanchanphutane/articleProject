<?php

namespace App\Controller;


use App\Document\User;
use App\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Request;



class FosController extends AbstractController
{
    /**
     * @Route("/fos", name="fos")
     */
    public function index(): Response
    {
        return $this->render('fos/index.html.twig', [
            'controller_name' => 'FosController',
        ]);
    }


    public function register(DocumentManager $dm,Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $data = $form->getData();
			$dm->persist($data);
            $dm->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Great! User has been added succesfully!!!');
            
            // Redirect to your specific file
            return $this->redirectToRoute('login');
            }
        return $this->render('user/register.html.twig',[
            'form' => $form->createView(), 
        ]);    
    }




    // /** 
    //  * @Route("/usermanagement/edit/{id}", name="editUser")
    //  **/

   
    public function update(DocumentManager $dm,Request $request, $id)
    {
        $user = $dm->find(User::class, $id);

        $form = $this->createForm(UserForm::class, $user, ['method'=>'PUT']);
        $form->handleRequest($request);

        
		 if ($form->isSubmitted()) {

            // $response = $this->client->request(
            //     'GET',
            //     'https://'
            // );

            $data = $form->getData();
            // $data = json_decode($request->getContent(), true);
            // $data = $response->getContent();
			$dm->persist($data);
            $dm->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('info', 'User has been updated succesfully!!!');
            
            return $this->redirectToRoute('usermanagement');
        }

        return $this->render('user/edituser.html.twig', [
            'form' => $form->createView(), 
        ]);
    }


    public function deleteUser(DocumentManager $dm,$id)
    {
        $user = $dm->find(User::class, $id);
        if($user){
            $dm->remove($user);
            $dm->flush();
            
            $this->addFlash('danger', 'You deleted a User');
            
        }else{
            throw $this->createNotFoundException(
                'No id found as ' . $id
                );
        }
        return $this->redirectToRoute('usermanagement');
    }

    


}
