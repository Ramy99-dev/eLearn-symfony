<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\CoursRepository;


class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session , CoursRepository $coursRepository): Response
    {
        $panier = $session->get('panier' , []); 
        $somme = 0;
        
        $panierWithData = [];
        foreach ($panier as $id => $val) {
            
            
            $panierWithData[]=[
                'cour'=>$coursRepository->find($id)
            ];
            
        }
        foreach ($panierWithData as $key => $value) {
    
            $somme += $value['cour']->getPrice();
        }
   
    
        return $this->render('achat/achat.html.twig', [
         'cours'=>$panierWithData,
         'total'=>$somme
        ]);
    }
    /**
     * @Route("/panier/add/{id}" , name="panier_add")
     */
    public function add($id , SessionInterface $session)
    {
        $panier = $session->get('panier' ,   []);
      
        $panier[$id]= $id;
        $session->set('panier' , $panier);
        return $this->redirectToRoute('list_cours');
    }
}
