<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Actor;
use DataTables\DataTableResults;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax", name="ajax_", condition="request.isXmlHttpRequest()")
 */
class AjaxRequestController extends Controller
{
    /**
     * @Route("/films", name="films")
     * @param Request $request
     */
    public function films(Request $request)
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
        switch ($orders[0]['column']) {
            case 0: $order_column = 'f.id'; break;
            case 1: $order_column = 'f.name'; break;
            case 2: $order_column = 'f.genre'; break;
            case 3: $order_column = 'f.dateCreate'; break;
            case 4: $order_column = 'fs.name'; break;
            case 5: $order_column = 'fs.phone'; break;
            case 6: $order_column = 'fs.address'; break;
        }

        $conditions['order_column'] = $order_column;
        $conditions['order_dir'] = $orders[0]['dir'];

        // Restrict results.
        $conditions['length'] = $request->get('length');
        $conditions['start'] = $request->get('start');

        // Get films by condition.
        $films = $repository->findFilmsByConditions($conditions);
        // Count films by condition.
        $results->recordsFiltered = $repository->getCountFilmsByConditions($conditions);
        // Total number of films.
        $results->recordsTotal = $repository->getTotalFilms();

        foreach ($films as $film) {
            $actors = "<ul>";
            foreach ($film->getActors() as $actor) {
                $actors.= "<li>" . $actor->getName() . "</li>";
            }
            $actors.= "</ul>";

            $results->data[] = [
                $film->getId(),
                $film->getName(),
                $film->getGenre(),
                $film->getDateCreate()->format('M d, Y'),
                $film->getStudio()->getName(),
                $film->getStudio()->getPhone(),
                $film->getStudio()->getAddress(),
                $actors,
            ];
        }
        return $this->json($results);
    }

    /**
     * @Route("/actors", name="actors")
     * @param Request $request
     */
    public function actors(Request $request)
    {
        $results = new DataTableResults();
        $conditions = [];
        $repository = $this->getDoctrine()->getRepository(Actor::class);

        // Search.
        $search = $request->get('search');
        if (!empty($search['value'])) {
            $conditions['search'] = trim($search['value']);
        }

        // Order.
        $orders = $request->get('order');
        switch ($orders[0]['column']) {
            case 0: $order_column = 'a.id'; break;
            case 1: $order_column = 'a.name'; break;
            case 2: $order_column = 'a.email'; break;
            case 3: $order_column = 'a.phone'; break;
        }

        $conditions['order_column'] = $order_column;
        $conditions['order_dir'] = $orders[0]['dir'];

        // Restrict results.
        $conditions['length'] = $request->get('length');
        $conditions['start'] = $request->get('start');

        // Get actors by condition.
        $actors = $repository->findActorsByConditions($conditions);
        // Count actors by condition.
        $results->recordsFiltered = $repository->getCountActorsByConditions($conditions);
        // Total number of actors.
        $results->recordsTotal = $repository->getTotalActors();

        foreach ($actors as $actor) {
            $films = "<ul>";
            foreach ($actor->getFilms() as $film) {
                $films.= "<li>" . $film->getName() . "</li>";
            }
            $films.= "</ul>";

            $results->data[] = [
                $actor->getId(),
                $actor->getName(),
                $actor->getEmail(),
                $actor->getPhone(),
                $films,
            ];
        }
        return $this->json($results);
    }
}
