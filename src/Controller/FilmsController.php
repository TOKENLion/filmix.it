<?php

namespace App\Controller;

use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FilmsController extends Controller
{
    /**
     * @Route("/", name="films")
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $search = trim($search);

        $repository = $this->getDoctrine()->getRepository(Film::class);
        $all_films = $repository->findFilmsByConditions(['search' => $search]);
        $paginator = $this->get('knp_paginator');

        $films = $paginator->paginate(
            $all_films,
            $request->query->getInt('page', 1),
            5,
            [
                'align' => 'center',
                'size' => 'small'
            ]
        );

        return $this->render('films/index.html.twig', ['films' => $films]);
    }

    /**
     * @Route("/ajax_film", name="search_film")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax_request(Request $request){
        $search = $request->get('search');
        $search = trim($search);

//        if (empty($search)) {
//            return new JsonResponse(['message' => 'Invalid data request', 'status' => 'warning']);
//        }

        $repository = $this->getDoctrine()->getRepository(Film::class);
        $films = $repository->findFilmsByConditions(['search' => $search]);

        if (empty($films)) {
            return new JsonResponse(['content' => '', 'status' => 'success']);
        }

        $content = $this->renderView('films/partial/films_rows.html.twig', ['films' => $films]);
        return new JsonResponse(['content' => $content, 'status' => 'success']);
    }
}
