<?php

namespace App\Controllers;

use App\Core\Form;

class UsersController extends Controller
{
    // je crée une fonction login qui va nous permettre de génerer notre form : 

    public function login()
    {
        // on peut importer notre class Form et l'instancier:

        $form = new Form;

        // je peux lancer ma méthode debutForm et je vais rien metttre dedans ce qui va me lanncer les ^paramètre par défaut méthode post et action #, ensuite je peux faire un finForm qui demande aucun paramètre
        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput("email", "email", ['class' => 'form-control', 'id' => 'email'])
            ->finForm();
    }
}
