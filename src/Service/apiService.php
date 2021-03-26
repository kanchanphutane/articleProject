<?php

namespace App\Service;
use AppBundle\Factory\OrderFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use App\Controller\UserController;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class apiService 
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    public function __construct(UserController $UserController,LoggerInterface $logger) 
    {
        $this->logger = $logger;
        $this->UserController = $UserController;
    }

    
    // /**
    // * @Rest\Get("/usermanagement/edit/{id}", name="editUser")
    // */
    public function update(DocumentManager $dm,Request $request, $id)
    {
        $user = $dm->find(User::class, $id);

        $form = $this->createForm(UserForm::class, $user, ['method'=>'PUT']);
        $user->handleRequest($request);

        
		 if ($form->isSubmitted()) {

            // $response = $this->client->request(
            //     'GET',
            //     'https://'
            // );

            $data = $form->getData();
            // $data = $response->getContent();
			$dm->persist($data);
            $dm->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('info', 'User has been updated succesfully!!!');
            
            return $this->redirectToRoute('user/edituser.html.twig');
        }

        return $this->render('user/edituser.html.twig',
            ['form' => $form->createView()]
        );
    }

    

}




?>