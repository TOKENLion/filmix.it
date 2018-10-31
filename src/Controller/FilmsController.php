<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends Controller
{
    /**
     * @Route("/", name="films")
     */
    public function index()
    {
        return $this->render('films/index.html.twig');
    }
}
