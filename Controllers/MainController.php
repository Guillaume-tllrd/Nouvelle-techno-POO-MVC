<?php

namespace App\Controllers;

class MainController extends Controller
{

    public function index()
    {
        // pour avoir un render ndifférent pour la page d'acceuil en se servant du home et pas du default:
        // je t'envoie pas de donnée et esnuite utilise home
        $this->render('main/index', [], 'home');
    }
}
