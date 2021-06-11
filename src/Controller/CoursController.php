<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Cours;
use App\Form\CoursType;
use App\Entity\Category;
use App\Entity\CoursLike;
use App\Repository\CourRepository;
use App\Repository\CoursRepository;
use App\Repository\CategoryRepository;
use App\Repository\CoursLikeRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/cours")
 */
class CoursController extends AbstractController
{
   
    /**
    * @Route("/allcours", name="list_cours", methods={"GET","POST"})
    */
    public function listCours(CoursRepository $coursRepository, CategoryRepository $catRepo , SessionInterface $session)
    {
        $panier = $session->get('panier' , []);
        return $this->render('cours/cours.html.twig', [
            'cours' => $coursRepository->findAll(),
            'categorie'=>$catRepo->findAll(),
            'nbrPanier'=>sizeof($panier)
        ]);
    }
    /**
     * @Route("/", name="cours_index", methods={"GET","POST"})
     */
    public function index(CoursRepository $coursRepository ): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
         
            
            
        ]);
    }
     /**
     * @Route("/byCategory/{categ}", name="cours_findby", methods={"GET","POST"})
     */
    public function showByCategory(CoursRepository $coursRepository ,  $categ ,CategoryRepository $catRepo , SessionInterface $session):Response
    {
        $panier = $session->get('panier' , []);
        return $this->render('cours/index.html.twig', [
             'cours'=>$coursRepository->findBy(array('categorie'=>$categ)),  
             'categorie'=>$catRepo->findAll(),
             'nbrPanier'=>sizeof($panier)
        ]);
    }

    /**
     * @Route("/new/{id}", name="cours_new", methods={"GET","POST"})
     */
    public function new(Request $request ,UserInterface $user): Response
    {
        $cour = new Cours();
       
        $form = $this->createForm(CoursType::class, $cour);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('img')->getData();
            if($file !=null)
            {
                $uploadsDir = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $uploadsDir,
                    $filename
                );
                $cour->setImg($filename);
            }
            
            $cour->setAutor($user);
            $cour->setUploadDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('list_cours');
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/{id}", name="cours_show", methods={"GET"})
     */
    public function show(Cours $cour): Response
    {
        
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cours_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cours $cour): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cours_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cours $cour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cours_index');
    }
    /**
     * @Route("/{id}/like" , name="cours_like")
     */
    public function like(Cours $cours ,  CoursLikeRepository $likeRepo):response 
    {
        $user = $this->getUser();
        if(!$user){
            return $this->json([
                'code'=>403,
                'message'=>'Unauthorized'
            ],403);
        }
        if($cours->isLikedByUser($user)==true)
        {
            $like = $likeRepo->findOneBy([
                'cours'=>$cours,
                'user'=>$user
            ]);
            $this->getDoctrine()->getManager()->remove($like);
            $this->getDoctrine()->getManager()->flush();
            return $this->json([
                'code'=>200,
                'message'=>'like supprimer',
                'likes'=>$likeRepo->count(['cours'=>$cours])
            ],200);
            
        }
        $like = new CoursLike();
        $like->setCours($cours)
              ->setUser($user);
         $this->getDoctrine()->getManager()->persist($like);
         $this->getDoctrine()->getManager()->flush();

         return $this->json([
            'code'=>200,
            'message'=>'like ajouter',
            'likes'=>$likeRepo->count(['cours'=>$cours])
         ],200);
         

    }
    
   
}
