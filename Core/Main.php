<?php

namespace App\Core;

use App\Controllers\MainController;

// Router principal
class Main
{
    public function start()
    {
        // http://mes-annonces.test/controleur/methode/parametres
        // http://mes-annonces.test/annonces/details/brouette
        // il faut qu'on utilise une méthode réécriture d'url pour qu'on est:
        // http://mes-annonces.test/index.php?p=annonces/details/brouette

        // On retire le "trailing slash" éventuel de l'url (dernier slash)
        // On récupère l'URL:
        $uri = $_SERVER["REQUEST_URI"];

        // On vérifiz que uri n'esg pas vide et se termine par un /
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            // on enlève le /
            $uri = substr($uri, 0, -1); // on commence à 0 et on finit à -1;

            // ON envoie un code de redirection permanenete:
            http_response_code(301);

            // on redirige vers l'url sans /
            header("Location :" . $uri);
        }

        // on gère les paramètres d'URL
        // p=controleur/methode/paramètres
        // on va récupérer directement les paramètres et les metres sous forme de tableau avec explode
        // on sépare les paramètres dans un tableau:
        // on retire le "/" et on met un paramètre p que l'on défini dans le htaccess
        $params = explode('/', $_GET['p']);

        if ($params[0] != "") {
            // ici on a au moins 1 paramètre:
            // on va devoir démonter le tableau qu'on a créé au niveau du explode, la 1ere partie du tableau va être le controlleur, la 2ème va être la méthode, ensuite sa sera les parameètres qu'on envoie dans la méthode
            // on récupère le nom du controlleur à instancier , on doit fabriquer son nom car il n'est pas dans le même nmespace
            // on met une majuscule en premier lettre, on ajioute le namespace complet avant et on ajoute "controller" après:
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            // array_shift = enelve le 1er paramètre d'un tableau

            // on instancie le controleur:
            $controller = new $controller();

            // on récupère le 2ème paramètre de l'url:
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            // permet de vérifier si dans le controller on a une méthode action qui existe
            if (method_exists($controller, $action)) {
                // si il reste des paramètres on mles passe à la méthode
                (isset($params[0])) ? $controller->$action($params) : $controller->$action();
            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        } else {
            // si jamais on a pas de paramètres, on va faire un controleur par default qu'on va appelr mainController et qui sera dans controllers
            // on instancie le controllers par défaut: 
            $controller = new MainController;

            // On appelle la méthode index
            $controller->index();
        }
    }
}
// arreté a 1:03:50
