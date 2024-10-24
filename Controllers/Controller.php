<?php

namespace App\Controllers;
// on rajoute abstact car ce controlleur principal est une classe abstraite, cad qu'elle sert de modèle de base pour d'aurtres class qui vont l'hériter. Elle ne peut être instanciée directement ex: on ne peut faire $controller = new Controller; 
// En déclarant la classe comme abstraite, tu t'assures que cette classe est utilisée uniquement pour hériter des fonctionnalités communes, sans permettre son instanciation directe. Cela permet également de montrer que c'est la classe principale pour les autres contrôleurs, servant de modèle.
abstract class Controller
{

    public function render(string $fichier, array $donnees = [], string $template = 'default')
    {

        // on extrait le contenu des donnes avec la méthode extract
        extract($donnees); //je démonte mon array

        // il faut que mon render puisse injecter mon contenu à l'intérieur de mon template dans le fichier default, on va utiliser un buffer de srtie cad qu'on va demander à php de mettre en mémoire toutes les balises html ou echo et tu le met dans une variable

        // on démarre le buffer de sortie (outlook buffer): 
        ob_start();
        //  à partir de ce point toute sortie est conservé en mémoire
        // tout ce qui est entre ob_start et ob_get_clean il le met en mémoire, donc on le met après avoir charger notre vue


        // on crée le chemin vers la vue. le $fichier qu'on récupère dans AnnoncesController par ex avec le render
        require_once ROOT . '/Views/' . $fichier . '.php';
        $contenu = ob_get_clean(); // stock le buffer dans la var

        // on récupère le template du default
        require_once ROOT . '/Views/' . $template . '.php';
    }
}

// différence entre require et include require si ca marche pas on a une erreur fatal et include warning 