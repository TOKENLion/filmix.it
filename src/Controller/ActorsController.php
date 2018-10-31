<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ActorsController extends Controller
{
    /**
     * @Route("/actors", name="actors")
     */
    public function index()
    {
        return $this->render('actors/index.html.twig');
    }
}
