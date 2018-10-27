<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActorsController extends Controller
{
    /**
     * @Route("/actors", name="actors")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Actor::class);
        $actors = $repository->findActorsByConditions();
        return $this->render('actors/index.html.twig', ['actors' => $actors]);
    }

    /**
     * @Route("/ajax_actor", name="search_actor")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax_request(Request $request){
        $search = $request->get('search');
        $search = trim($search);

//        if (empty($search)) {
//            return new JsonResponse(['message' => 'Invalid data request', 'status' => 'warning']);
//        }

        $repository = $this->getDoctrine()->getRepository(Actor::class);
        $actors = $repository->findActorsByConditions(['search' => $search]);

        if (empty($actors)) {
            return new JsonResponse(['content' => '', 'status' => 'success']);
        }

        $content = $this->renderView('actors/partial/actors_rows.html.twig', ['actors' => $actors]);
        return new JsonResponse(['content' => $content, 'status' => 'success']);
    }
}
