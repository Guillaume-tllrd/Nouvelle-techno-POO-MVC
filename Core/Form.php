<?php

namespace App\Core;

class Form
{

    private $formCode = "";

    // étant donné qu'il est en privé on doit faire une méthode public(getter) qu'on appelle create 
    // génère le formulaire HTML
    public function create()
    {
        //  on retourne le code qui a été généré
        return $this->formCode;
    }

    // on fait une méthode validation des données du tableau: 
    // -on récupère la méthode du form(post ou get) et une liste de champs (obligatoire) pour savoir si tous ses champs sont validés 
    // je récupère sous forme de tableau le formulaire et le champs
    public static function validate(array $form, array $champs)
    {
        // on la met en statit comme ça on pourra l'interoger sans avoir à l'instancier l'objet
        // on parcourt les champs: (avec un foreach)
        foreach ($champs as $champ) {
            // si le champ est absent ou vide dans le formulaire
            if (!isset($form[$champ]) || empty($form[$champ])) {
                // on sort en retournant false
                return false;
            }
        }
        // sinon on retun true mais on pourrait rajouter des validations de contenu,ex: est-ce que l'email est bien un email etc.
        return true;
    }

    // on fait une méthode qui va me permettre d'ajouter les attributs des balises du formulaire
    // elle reçoit les attributs sous forme de tableau (ex: ['class' => 'form-control', 'required' => true]) et retournera une chaine de carctère
    private function ajoutAttribut(array $attributs): string
    {
        // on inititialise une chaine de carctères: 
        $str = '';
        // on liste les attributs 'courts':
        $courts = ['checked', 'disabled', 'required', 'readonly', 'multiple', 'autofocus', 'novalidate', 'formnovalidate'];

        // on boucle sur le tableau d'attributs
        foreach ($attributs as $attribut => $valeur) {
            // est-ce que c'est $attribut court? estce que la valeur d'atttribut est dans mon tableau $courts et que sa valeur est true:
            if (in_array($attribut, $courts) && $valeur == true) {
                // si c'est le cas on ajoute a str un espace et notre $attribut (on sépare les attributs par des esapces):
                $str .= " $attribut";
            } else {
                // si jamais c'est pas un attribut court OU que savleur est false alors on ajoute attribut='valeur';
                $str .= " $attribut= '$valeur'";
            }
        }
        return $str;
    }

    // on crée une méthode pour la BALISE D'ouverture du FORMULAIRE qui va renvoyer l'objet lui-même et qui aura besoin d'une méthode qui aura post en default , une action qui sera en default # et un tableau des attributs complémentaire qui sera par défault vide 
    public function debutForm(string $methode = 'post', string $action = '#', array $attributs = []): self
    {
        // on crée la balise form: 
        $this->formCode .= "<form action='$action' method='$methode'";

        // on ajoute les attributs éventuels:
        // ternaire : si on a des attributs alors on lui passe les attributs sinon on fait rien et on ferme la balise form
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '>' : ">";


        return $this; // Retourne le formulaire
    }

    // Balise de fermture du formulaire:
    public function finForm(): self
    {

        $this->formCode .= '</form>';
        return $this;
    }

    // j'ai fait un form avec une méthode de début et de fin mtn je peux créer mon formulaire, je vais donc aller créer mon controller et comme c'est formulaire de login je vais créer un usersController

    // on fait également une méthode pour l'ajout de label que l'on indiquera dans le usercontroller :
    public function ajoutLabelFor(string $for, string $texte, array $attributs = []): self
    {

        // on ouvre la balise:
        $this->formCode .= "<label for='$for'";

        // on ajoute les attributs 
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) : "";

        // on ajoute le texte 
        $this->formCode .= ">$texte</label>";

        return $this;
    }

    // on fait également une méthode pour les inputs:
    public function ajoutInput(string $type, string $nom, array $attributs = []): self
    {
        // on ouvre la balise
        $this->formCode .= "<input type='$type' name='$nom'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '>' : '>';

        return $this;
    }

    public function ajoutTextarea(string $nom, string $valeur = '', array $attributs = []): self
    {

        // on ouvre la balise:
        $this->formCode .= "<textarea for='$nom'";

        // on ajoute les attributs 
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) : "";

        // on ajoute le texte 
        $this->formCode .= ">$valeur</textarea>";

        return $this;
    }

    // méthode pour les select: 
    public function ajoutSelect(string $nom, array $options, array $attributs = []): self
    {

        // on crée le select 
        $this->formCode .= "<select name='$nom'";

        // on ajoute les attriubuts 
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '>' : '>';

        // on ajoute les options : 
        foreach ($options as $valeur => $texte) {
            $this->formCode .= "<option value='$valeur'>$texte</option>";
        }

        // on ferme le select 
        $this->formCode .= '</select>';

        return $this;
    }

    public function ajoutBouton(string $texte, array $attributs = []): self
    {

        // on ouvre le bouton
        $this->formCode .= "<button '";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) : "";

        // on ajoute le texte et on ferme le bouton: 
        $this->formCode .= ">$texte </button>";

        return $this;
    }
}
