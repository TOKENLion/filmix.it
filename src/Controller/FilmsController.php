<?php

namespace App\Controller;

use App\Entity\Film;
use DataTables\DataTableResults;
use DataTables\DataTableQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FilmsController extends Controller
{
//    /**
//     * @Route("/", name="films")
//     */
//    public function index(Request $request)
//    {
//        $search = $request->get('search');
//        $search = trim($search);
//
//        $repository = $this->getDoctrine()->getRepository(Film::class);
//        $all_films = $repository->findFilmsByConditions(['search' => $search]);
//        $paginator = $this->get('knp_paginator');
//
//        $films = $paginator->paginate(
//            $all_films,
//            $request->query->getInt('page', 1),
//            5,
//            [
//                'align' => 'center',
//                'size' => 'small'
//            ]
//        );
//
//        return $this->render('films/index.html.twig', ['films' => $films]);
//    }

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

    /**
     * @Route("/", name="films")
     */
    public function test_me(){
        return $this->render('films/test-me.html.twig');
    }

    /**
     * @Route("/users", name="users")
     * @param Request $request
     */
    public function test_me2(Request $request)
    {
        $results = new DataTableResults();
        $conditions = [];
        $repository = $this->getDoctrine()->getRepository(Film::class);

        // Search.
        $search = $request->get('search');
        if (!empty($search['value'])) {
            $conditions['search'] = trim($search['value']);
        }

        // Order.
        $orders = $request->get('order');
        foreach ($orders as $order) {
            switch ($order['column']) {
                case 0: $order_column = 'f.id'; break;
                case 1: $order_column = 'f.name'; break;
                case 2: $order_column = 'f.genre'; break;
                case 3: $order_column = 'f.dateCreate'; break;
                case 4: $order_column = 'fs.name'; break;
                case 5: $order_column = 'fs.phone'; break;
                case 6: $order_column = 'fs.address'; break;
            }

            $conditions['order_column'] = $order_column;
            $conditions['order_dir'] = $order['dir'];
        }

        // Restrict results.
        $conditions['length'] = $request->get('length');
        $conditions['start'] = $request->get('start');

        // Total number of films.
        $results->recordsTotal = $repository->getTotalFilms();

        $films = $repository->findFilmsByConditions($conditions);
        $results->recordsFiltered = 10;
        foreach ($films as $film) {
            $results->data[] = [
                $film->getId(),
                $film->getName(),
                $film->getGenre(),
                $film->getDateCreate(),
                $film->getStudio()->getName(),
                $film->getStudio()->getPhone(),
                $film->getStudio()->getAddress(),
                '55545',
            ];
        }
//        $output = new DataTableResults();
        return $this->json($results);
    }
}
