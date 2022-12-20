<?php

// on recupere nos variable envirement
include $_SERVER['DOCUMENT_ROOT'] . "/env.php";

class Register {
    private $pdo;

    public function __construct()
    {
        // on recupére nos information de notre basse donnée qui sont dans des variable envirement
        $host = getenv('MYSQL_HOST');
        $db = getenv('MYSQL_DATABASE');
        $user = getenv('MYSQL_USER');
        $pass = getenv('MYSQL_PASS');

        try {
            $this->pdo = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function createUser(string $user,string $pw)
    {

        // je prepare ma requeete pour évité les injection sql

        $requete = 'INSERT INTO user (pseaudo,pass) 
                    VALUE (:pseaudo,:pass)';

        $query = $this->pdo->prepare($requete);

        // j'execute ma requette 

        $query->execute([
            'pseaudo' => $user,
            'pass' => $pw,

        ]);
    }

    // methode qui va nous permetre de vérifié si le pseaudo exite déja
    public function verified($name)
    {
        // je prépare ma requette pour vérifier si un utilisateur éxite dans ma BDD
        $query = $this->pdo->prepare('SELECT * FROM user WHERE pseaudo=:name');

        // J'execute la requette
        $query->execute(['name' => $name]);

        $user = $query->fetch();
        if (!empty($user)) {
            return false;
        } else {
            return true;
        }
    }
}