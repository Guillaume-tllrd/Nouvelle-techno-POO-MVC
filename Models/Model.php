<?php

namespace App\Models;
// comme ça on sait qu'on est dans le dossier Models

use App\Core\Db;
// on ajoute car pas dans le même dossier 

// c'est une classe générale qui va permettre d'intéragir avec la db 
// Dans ce model il y aura un CRUD
// DONC C4EST UNE GROSSE CLASSE QUI VA CONTENIR PLEIN DE METHODES MAIS QUI SERTONT UTLISEES PAR DES PLUS PETITES CLASSES QUI CORRESPONDENT A NOS TABLE DE DONNEES
class Model extends Db
{

    // 1ère chose à faire: avoir une propriété pour la table de la base de données
    protected $table;

    // instance de db comme ça on pourra fait un this db pour récupérer directement notrre PDO
    private $db;

    // mtn que cette méthode query est faite je vais commencer mon CRUD :
    // je commence par le read: chercher l'information
    // je crée une méthode pour aller chercher tous les enregistrements de ma table
    public function findAll()
    {
        // trouve toutes les infos de ma table 
        $query = $this->requete('SELECT * FROM' . $this->table);
        // je fais un select * depuis la propriété table qu'on donnera, j'envoie la requête
        return $query->fetchAll();
    }

    // méthode finby permet d'aller chercher un ou plusieurs enregistrement en fonction de critères
    // cette fonction demande un tableau avec les critères
    public function findBy(array $criteres)
    {
        // on demande un tableau avec 2 colonnes: qui seront des tableaux vides
        $champs = [];
        $valeurs = [];

        // on boucle pour éclater le tableau
        foreach ($criteres as $champ => $valeur) {
            // on cherche à faire: SELECT * FROM annonces WHERE actif = ?
            // ensuite ça serait un bindValue(1, valeur)
            // dans un 1er temps je vais m'occuper de actif = ?:
            // dans notre array champs on va push([]) le nom de notre champ
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        // si on avait un==eu un champ en + avec par exemple un signal:
        // on transforme le tableau "champs" en un string  
        // $liste_champs = implode(' AND ', $champs);

        // on peut executer la requête 
        return $this->requete("SELECT * FROM '$this->table.' WHERE ' $champs, $valeurs")->fetchAll();
    }

    public function find(int $id)
    {
        return $this->requete("SELECT * FROM $this->table WHERE id = $id")->fetch();
        // Ici avec un fetch on aura juste une information contrairement au fetchAll où on doit faire une boucle
    }

    // ----------------CREATE------------------
    // d'abord il faut mettre en place dans ntre annoncesModel un structure avec tou lrs champs qui sont présents dans la bd et avec getter et setter 
    // ensuite on peut créer une méthode qui va prendre comme paramètre MOdel qu'on appel $model peu importe. comme on l'hydrate on a pas besoin de le passer en argument. donc on enlve également le $model dans le foreach et on met $this à la place, l'objet lui-même
    public function create()
    {
        // reprendre la méthode de findBy et on adapte:
        // on doit faire 3ème tableau qui reprend les "?"
        $champs = [];
        $inter = [];
        $valeurs = [];

        // le foreach se fait sur $model
        foreach ($this as $champ => $valeur) {
            // on cherche à faire: INSERT INTO  annonces (titre, description, actif) VALUES (?, ?, ?)
            // ensuite on fera un bindValue(1, valeur)
            // dans un 1er temps je vais m'occuper de actif = ?:
            // je dois faire un if car nous avons des valeurs en trop(db et table) dans notre tableau:donc: si notre valeur n'est pas nul qu'il n'est pas égal à db et table:
            if ($valeur != null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ; //ici c'est un string
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        // on transforme le tableau "champs" en un string  mais avec des "," et pas de and
        $liste_champs = implode(' , ', $champs);
        $liste_inter = implode(' , ', $inter);

        // on peut executer la requête 
        return $this->requete("INSERT INTO '$this->table.'('. $liste_champs.') VALUES ('.$list_inter.')', $valeurs");
        // pas de fetch sur un tableau d'INSERT

        // on peut faire une autre méthode pour le create qu'on appelle HYDRATATION cad passer d'un tableau qui viendra par ex d'une requete POST PUUIS ensuite hydraté l'objet avec une méthode hydrate
        // voir l'index pour voir un ex avec un tableau $donnees
    }

    // ----------------UPDATE------------------
    // LE update est très proche du create, il nous faut d'abord entier avec un id car je dois mettre à jour à partir d'un id. Pareil que pour le create come on a tout dans notre obj avec l'hydratation pas besoin de mettre d'argument
    public function update()
    {
        // on enleve les inter
        $champs = [];
        $valeurs = [];

        // le foreach se fait sur $model
        foreach ($this as $champ => $valeur) {
            // on cherche à faire: UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?;
            // ensuite on fera un bindValue(1, valeur)
            // dans un 1er temps je vais m'occuper de actif = ?:
            // je dois faire un if car nous avons des valeurs en trop(db et table) dans notre tableau:donc: si notre valeur n'est pas nul qu'il n'est pas égal à db et table:
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $this->id;
        // on transforme le tableau "champs" en un string  mais avec des "," et pas de and
        $liste_champs = implode(' , ', $champs);
        die($liste_champs);
        // on peut executer la requête 
        return $this->requete("UPDATE '$this->table.' SET '. $liste_champs.' WHERE id = ?', $valeurs");
    }
    public function requete(string $sql, array $attributs = null)
    {
        // je lui attribut une valeur null si il n'y en a pas
        // on va récupérer ou instancier db 
        $this->db = Db::getInstance();

        // on vérifie si on  des attributs :
        if ($attributs !== null) {
            // Requête préparée 
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // si on  pas d'attributs on aura une requête simple
            return $this->db->query($sql);
        }
    } // voilà ma méthode pour faire en sorte de faire contionner mes requêtes 

    public function delete(int $id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function hydrate($donnees)
    {
        // comme on fait passer un obj étant donné qu'on a changé notre fetch_assoc en fetch_obj on enlve le array de $donnees
        foreach ($donnees as $key => $value) {
            // on récupère le nom du setter correspondant à la clé(key)
            // ex: titre -> setTitre
            // on va concaténer en faisant une variable $setter :
            $setter = 'set' . ucfirst($key); // on concatène "set" avec la clé et sa 1ère letre en Uppercase

            // ensuite on vérifie si le setter existe, on tulise une méthode php (method_exist qui va chercher dans notre objet($this) si $setter existe)
            if (method_exists($this, $setter)) {
                // si oui on appelle le setter et on lui passe la valeur
                $this->$setter($value);
            }
        }
        // une fois qu'on a fini notre foreach on fait un return de notre objet hydraté
        return $this;
    }
}
