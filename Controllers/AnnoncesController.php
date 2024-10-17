<?php

namespace App\Controllers;

class AnnoncesController extends Controller
{

    public function index()
    {
        // on le dirige vers la page views annonces qui affiche le html
        include_once ROOT . '/Views/annonces/index.php';
    }
}
