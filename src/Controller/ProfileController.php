<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\EditProfileType;
use App\Repository\CoursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function index($id , CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findBy(array('autor'=>$id));
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'cours' => $cours,
        ]);
    }
    
     /**
     * @Route("/{id}/profile_edit", name="profile_edit")
     */
    public function editProfile( Request $request , SluggerInterface $slugger , $id):Response
    {
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $img = $user->getImg();
        $form = $this->createForm(EditProfileType::class, $user);
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
                $user->setImg($filename);
            }
            else{
                $user->setImg($img);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('profile',['id'=>$id]);
        }
        return $this->render('profile/edit.html.twig', [
            'editForm' => $form->createView(),
        ]);
    }

    
}
