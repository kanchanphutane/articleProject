<?php

namespace App\Controller;

use App\Document\Article;
use App\Form\ArticleForm;
use App\Document\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="articlePage", methods={"GET","POST"})
     */
    public function index(DocumentManager $dm)
    {
        $myArticle = $dm->createQueryBuilder(Article::class)
            ->limit(10)
            ->skip(0)
            ->sort('artName', 'ASC')
            ->getQuery()
            ->execute();

          return $this->render('article/index.html.twig', [
            'article' => $myArticle,
        ]);

           
    }
    

    /**
     * @Route("/article/addArticle", name="addPage", methods={"GET","POST"})
     */
    public function add(DocumentManager $dm,Request $request)
    {
        $article = new Article();
        $article->setCreatedAt(new \DateTime('now'));
        $form = $this->createForm(ArticleForm::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $uploadedFile = $form['artImage']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $article->setArtImage($newFilename);

            $data = $form->getData();
			$dm->persist($data);
            $dm->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Great! Article has been added succesfully!!!');
            
            // Redirect to your specific file
            return $this->redirectToRoute('articlePage');
            }
        return $this->render('article/add.html.twig',[
            'form' => $form->createView(), 
        ]);    
    }

    /**
     * @Route("/article/updateArticle/{id}", name="updatePage")
     */
    public function update(DocumentManager $dm,Request $request, $id)
    {
        $article = $dm->find(Article::class, $id);
        $article->setUpdatedAt(new \DateTime('now'));

        $form = $this->createForm(ArticleForm::class, $article, ['method'=>'PUT']);
        $form->handleRequest($request);

        
		if ($form->isSubmitted()) {

            $uploadedFile = $form['artImage']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
            );
            $article->setArtImage($newFilename);
            }

            $data = $form->getData();
			$dm->persist($data);
            $dm->flush();
            $request->getSession()
                    ->getFlashBag()
                    ->add('info', 'Article has been updated succesfully!!!');
            
            return $this->redirectToRoute('articlePage');
        }
        return $this->render('article/update.html.twig', [
            'form' => $form->createView(), 
        ]);

    }

    /**
     * @Route("/article/delete/{id}", name="deletePage")
     */
    public function delete(DocumentManager $dm,$id)
    {
        $article = $dm->find(Article::class, $id);
        if($article){
            $dm->remove($article);
            $dm->flush();
            
            $this->addFlash('danger', 'You deleted a Article!!!');
            
        }else{
            throw $this->createNotFoundException(
                'No id found as ' . $id
                );
        }
        return $this->redirectToRoute('articlePage');
    }


    /**
     * @Route("/articleListing", name="articleListingPage", methods={"GET","POST"})
     */
    public function articleListing(DocumentManager $dm)
    {
        $myArticle = $dm->createQueryBuilder(Article::class)
            ->limit(10)
            ->skip(0)
            ->sort('artName', 'ASC')
            ->getQuery()
            ->execute();
           
          return $this->render('article/articleListing.html.twig', [
            'article' => $myArticle,
        ]);
           
    }
    

    /**
     * @Route("articleListing/viewArticle/{id}", name="viewPage")
     */
    public function viewAction(DocumentManager $dm,Request $request, $id)
    {
        $output = array();  
        $article = $dm->getRepository(Article::class)->find($id);
        // $myComment = $dm->getRepository(Comment:class)->getQuery()->execute();

        $user_id = $this->get('session')->get('user_id');
        // $user_id = $this->session->get('user_id');

        $myComment = $dm->createQueryBuilder(Comment::class)
                ->field('articleid')->equals($id)
                ->getQuery()
                 ->execute();

                // ->getSingleResult();
                //   dd($myComment);      

        if(!$myComment){
            $request->getSession()
                    ->getFlashBag()
                    ->add('notice','No comments found.Be the first one to comment!');
        }

        if (!$article) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }

        if($request->isMethod('post'))
        {
            $authorname = $request->request->get('authorname');
            $ucomment = $request->request->get('comment');
            // $articleid = $request->request->get('articleid');
            // $uid = $request->request->get('user_id');
            
            // $replyToId = $request->request->get('comment_id');

            $comment = new Comment();
            $comment->setAuthorname($authorname);
            $comment->setComment($ucomment);
            $comment->setArticleid($id);
            $comment->setUserid($user_id);
            $comment->setCreatedAt(new \DateTime('now'));
            
            // $comment->handleRequest($request);
            $dm->persist($comment);
            $dm->flush();
            // $comment->getId();
            $request->getSession()
                    ->getFlashBag()
                    ->add('info', 'Comment has been added succesfully!!!');

                    // findAll() findBy(['articleid '=> $id])
            $commentData = $dm->getRepository(Comment::class)->findBy(array(),array('id'=>'DESC'),1,0);
          
            if($request->isXmlHttpRequest()){
                foreach($commentData as $rowComment){
                    $output[] = array("authorname" =>$rowComment->getAuthorname(),
                                    "comment" =>$rowComment->getComment(),
                                    "articleid" => $rowComment->getArticleid(),
                                    "userid" => $rowComment->getUserid(),
                                    "createdAt" => $rowComment->getCreatedAt());
                    }

                return new JsonResponse($output);
            }      
                // return new JsonResponse(array('status'=>'success'));
            
        }   
     
        return $this->render('article/view.html.twig', array(
                'article'=> $article,
                'mycomment'=> $myComment,
                'user_id' => $user_id,
                // 'data' => $comment
            )); 
             
    }
   

}