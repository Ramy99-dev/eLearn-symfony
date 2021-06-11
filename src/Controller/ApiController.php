<?php

namespace App\Controller;

use App\Repository\CourRepository;
use App\Repository\CoursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api" , methods={"GET"})
     */
    public function index(CoursRepository $coursRepo , SerializerInterface $serializer ) :Response
    {
        
        return $this->json($coursRepo->findAll(),200,["content-Type"=>"application/json"] , ['groups'=>'cours:read']);

    }
}
