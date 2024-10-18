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
            ->ajoutLabelFor('pass', 'Mot de passe :')
            ->ajoutInput('password', 'password', ['id' => "pass", 'class' => 'form-control'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();

        // pour faire afficher le formulaire, on utilise la méthode render du controller et on lui passe les données (loginForm), dans la vue(Views/users/login.php) on a juste à mettre le formulaire
        $this->render('users/login', ['loginForm' => $form->create()]);
    }

    // Inscription dees users
    public function register()
    {
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor("email", 'E-mail : ')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('pass', 'Mot de passe :')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('M\'inscrire' . ['id' => 'btn btn-primary'])
            ->finForm();

        // mtn qu'on a fini notre formulaire il faut l'envoyer sous le nom de registerForm à la vue: 'users/register' 
        $this->render('users/register', ['registerForm' => $form->create()]);
    }
}
