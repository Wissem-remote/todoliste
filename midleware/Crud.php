<?php



// on recupere nos variable envirement
include $_SERVER['DOCUMENT_ROOT']."/env.php";


class Crud {

    private $pdo;

    public function __construct()
    {
        // on recupére nos information de notre basse donnée qui sont dans des variable envirement
        $host = getenv('MYSQL_HOST');
        $db = getenv('MYSQL_DATABASE');
        $user = getenv('MYSQL_USER');
        $pass = getenv('MYSQL_PASS');
        
        try {
            $this->pdo = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getFile(){
        // je recupere tout mes documment dans ma BDD
        $v = $this->pdo->query('SELECT * FROM document')->fetchAll();
        return $v;
    }

    public function addDocument($pic){
        // je prepare ma requeete pour évité les injection sql

        $requete = 'INSERT INTO document (name) 
                    VALUE (:name)';

        $query = $this->pdo->prepare($requete);

        // j'execute ma requette 

        $query->execute([
            'name' => $pic
        ]);
    }

    public function deleteName($id)
    {
        // je prepare ma requeete pour évité les injection sql

        $requete = 'DELETE FROM document WHERE id=(:id)';

        $query = $this->pdo->prepare($requete);

        // j'execute ma requette 

        $query->execute([
            'id' => $id
        ]);
    }
}