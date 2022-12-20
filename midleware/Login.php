<?php


// on recupere nos variable envirement
include $_SERVER['DOCUMENT_ROOT'] . "/env.php";

class Login {

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

    // methode qui va me permetre de me connecter en fonction des information dans ma BDD
    public function login(string $user, string $pass)
    {
        // je prepare ma requete pour évité les injection sql pour voir si pseaudo coorespond
        $query = $this->pdo->prepare('SELECT * FROM user WHERE pseaudo=:pseaudo');

        // J'execute la requette
        $query->execute(['pseaudo' => $user]);

        
        $user = $query->fetch(); 
        // je verifie si le mot passe entrer coorespond
        if(!empty($user) && password_verify($pass,$user->pass)){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['auth'] = $user->id;

            return $user;
        }else{
            // sinom je retourne null
            return null;
        }
        
    }

    // methode qui va nous permetre de véfirifer si utilisateur est connecter avec les bon identifiant 
    public function access($id){
        // je prepare ma requete pour évité les injection sql pour voir si pseaudo coorespond
        $query = $this->pdo->prepare('SELECT * FROM user WHERE id=:id');

        // J'execute la requette
        $query->execute(['id' => $id]);

        $user = $query->fetch();

        if(!empty($user)){
            return $user;
        }else{
            return null;
        }
    }

}