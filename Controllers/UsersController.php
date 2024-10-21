<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    // on crée d'abord à la main pour vérifier la session:
    // $_SESSION['user'] = ["id" => 1, "email" => 'contact@nouvelle-techno.fr'];
    // La bonne pratique est de faire une nouvelle méthode 'setSession' dans userModel


    // je crée une fonction login qui va nous permettre de génerer notre form : 
    public function login()
    {
        // On vérifie si le formulaire est valide:
            if(Form::validate($_POST, ['email', 'password'])){
                // Le formulaire est complet
                // On va chercher dans la bdd l'utilisateur avec l'email entré
                $usersModel = new UsersModel;
                $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));
    
                if(!$userArray){
                    $_SESSION['error'] = "L'adresse e-mail et/ou le mot de passe est incorrect";
                    header('Location: /users/login'); // pour rafraichir la page
                    exit;
                }
                // l'utilisateur existe, on hydrate l'obet de type user
                $user = $usersModel->hydrate($userArray);
                var_dump($user);

                // on vérifie si le mdp est correct: 
                if(password_verify($_POST['password'], $user->getPassword())){
                    // le mdp est bon, on lance la session et on peut redirigé vers la page d'accueil :
                    $user->setSession();
                    header('Location: /');
                    exit;
                } else {
                    // mauvais mdp:
                    $_SESSION['error'] = "L'adresse e-mail et/ou le mot de passe est incorrect";
                    header('Location: /users/login'); // pour rafraichir la page
                    exit;
                }
    
            }
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

    // Inscription des users
    public function register()
    {
        // comme on a fait une fonction static de validate on peut l'indenté directement:, on vérifie si le form est valide cad qur dans notre $_POST il y a email et password:
        if(Form::validate($_POST, ['email', 'password']){
            // le formulaire est valide
            // 1ere chose on nettoie l'email pour les fails XSS:
            $email = strip_tags($_POST['email']);

            // on chiffre le mdp : 
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            // on stocke l'utilmisateur en bdd: C'EST PLUTÔT ON HYDRATE L'UTILISATEUR:
            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass);

            // on stocke l'utilisateur: on execute le create dans Model, ça récupère $this qui représente le usersModel avec les propriétés email et password
            $user->create();
        })

        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor("email", 'E-mail : ')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control']) // je met une classe car je suis en bootstrap
            ->ajoutLabelFor('pass', 'Mot de passe :')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('M\'inscrire' . ['class' => 'btn btn-primary'])
            ->finForm();

        // mtn qu'on a fini notre formulaire il faut l'envoyer sous le nom de registerForm à la vue: 'users/register' 
        $this->render('users/register', ['registerForm' => $form->create()]);
    }

    public function logout(){
        unset($_SESSION['user']);
        header('Location:'.$_SERVER['HTTP_REFERER']); // ça renvoie sur la page où on est situé
        exit;
    }
}
