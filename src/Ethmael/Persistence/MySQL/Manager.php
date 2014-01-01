<?php

namespace Ethmael\Persistence\MySQL;

class Manager {

    // Constructor of the class
    // Do nothing
    public function __construct() {
    }

    // Create a connection to SQL Database
    private function connectSQL() {

        include("php/_connexion.php");
        try {
            $info = "mysql:host=".$host.";dbname=".$bdd;
            $basedd = new PDO($info, $user, $pass);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return $basedd;
    }

    // create a new ressource in ressource table
    // return : object ressource
    public function createRessource($nom, $level, $prix) {

        $maConnection = $this->connectSQL();

        $requete = "INSERT INTO ressource(nom, niveau, prix) VALUES(:nom,:level,:prix)";
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array(
            'nom' => $nom,
            'level' => $level,
            'prix' => $prix));

        $reponse->closeCursor();

        $requete = "SELECT id_ressource FROM ressource WHERE nom=?";
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array($nom));
        $donnees = $reponse->fetch();
        $maRessource = new Ressource($donnees['id_ressource']);

        return $maRessource;
    }

    // create a new game
    public function createPartie($login) {

        $maConnection = $this->connectSQL();
        // Desactive toutes les parties du joueur
        $requete ="UPDATE partie SET tour_actif=0 WHERE id_joueur=?" ;
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array($login));
        $reponse->closeCursor();

        // Creation / activation d'une nouvelle partie
        $requete ="INSERT INTO partie (id_joueur,tour_actif, nb_tour) VALUES (?,1,10);" ;
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array($login));
        $reponse->closeCursor();

        $requete = "SELECT id FROM partie WHERE id_joueur=:login AND tour_actif=1";
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array(
            'login' => $login));
        $donnees = $reponse->fetch();
        $maPartie = new Partie($donnees['id']);

        return $maPartie;

    }

    // create a new ville
    public function createVille($nom) {

        $maConnection = $this->connectSQL();

        // Creation d'une nouvelle ville
        $requete ="INSERT INTO ville (nom) VALUES (?);" ;
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array($nom));
        $reponse->closeCursor();
    }


    // associate Partie - Ville - Ressource
    public function createVilleRessource($id_partie, $id_ville, $id_ressource) {

        $maConnection = $this->connectSQL();

        // Creation d'une nouvelle ville
        $requete ="INSERT INTO p_ville_ressource (id_partie, id_ville, id_ressource) VALUES (?,?,?);" ;
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array($id_partie,$id_ville,$id_ressource));
        $reponse->closeCursor();
    }


    // verification of user rights
    function verif_login($nom, $password) {

        $maConnection = $this->connectSQL();

        $requete ="SELECT * FROM user WHERE login=:login AND pass=:password" ;
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array(
            'login' => $nom,
            'password' => $password));

        if($reponse->rowCount()>0){
            /* close statement */
            $reponse->closeCursor();
            return TRUE;
        }
        else{
            /* close statement */
            $reponse->closeCursor();
            return FALSE;
        }
    }

    // Verifie que le nom de session correspond à un utilisateur enregistré
    function check_session($nom) {

        $maConnection = $this->connectSQL();

        $requete ="SELECT * FROM user WHERE login=:login" ;
        $reponse = $maConnection->prepare($requete);
        $reponse->execute(array(
            'login' => $nom));

        if($reponse->rowCount()>0){
            /* close statement */
            $reponse->closeCursor();
            return TRUE;
        }
        else{
            /* close statement */
            $reponse->closeCursor();
            return FALSE;
        }
    }
}
?>
