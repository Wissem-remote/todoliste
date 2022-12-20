<?php



// on appelle notre plan qui va nous permetre de faire des opération 

include "./midleware/Login.php";


// notre plan qui va nous permetre de généré un token
include "./midleware/Csrf.php";

// on construie notre objet  qui va contenir nos opération Login

$db = new Login();


// test  des information on été soumie en post
if (empty($_POST)) {
    // je génère un token pour me premunir des attaques csurf
    $token = new Csrf;
}

if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    // on vérifie si session existe sinom on la crée

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }



    // je test si le token coorespond pour me prémunir des attaques csurf
    if (!empty($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {

        // pour évité les attacque XSS  je htmlentities mes donnée 

        $pw = htmlentities($_POST['pass']);
        $user = htmlentities($_POST['login']);


        // je recupere les informations dans ma base de donnée
        $user = $db->login($user, $pw);
        // je vérifie si le resultat coorespond à ma base de donnée
        if (!empty($user)) {
            // je suis connecter
            header("Location: /admin");
            die;
        } else {
            // sinom les informations ne coorespond pas aux informations dans ma base de donnée
            // je redirige avec un message erreur
            header("Location: /index.php?id=2");
            die;
        }
    } else {
        // si le token ne coorespond pas redirection sur la page acceuil
        header("Location: /index.php");
        die;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Acceuil</title>
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark ">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active" aria-current="page" href="/regiter">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container mt-5 ">
        <div class="row ">
            <div class="col-11 col-md-7 m-auto border rounded   p-3">

                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 1) {
                ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        Félicitation, vous êtes désormais inscrit
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 2) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Cet identifiant n'existe pas !
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <h1> Please sign in :</h1>
                <?php
                if (!empty($_SESSION['auth'])) {
                ?>
                    Un utilisateur est déja connecter connecter, souhaitez-vous déconnecter <a href="/admin/logout.php" class="text-decoration-none">Ici</a>
                <?php
                }
                ?>
                <form method="post">
                    <input type="text" name="login" class="form-control mt-4 mb-4" placeholder="Login" />
                    <input type="password" name="pass" class="form-control mb-4" placeholder="Password" />
                    <div class="col-5 col-lg-2 m-auto">
                        <button type="submint" class="btn btn-primary w-100 p-2
                        <?php
                        if (!empty($_SESSION['auth'])) {
                        ?>
                        disabled
                        <?php
                        }
                        ?>
                        "> Log in</button>
                    </div>
                    <input type="hidden" name="token" value="<?= $token->getToken(); ?>" />
                </form>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>