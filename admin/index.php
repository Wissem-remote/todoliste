<?php
// on appelle notre plan qui va nous permetre de faire des opération 

include "./../midleware/Login.php";

// on appelle notre plan qui va nous permetre de généré un token

include "./../midleware/Csrf.php";



// on appelle notre plan qui va nous permetre de manipuler nos document

include "./../midleware/Crud.php";

// on vérifie si session existe sinom on la crée

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// je recupere mon objet login
$login = new Login;

// pour voir si le utilisateur coorespond bien je verifie grace aux 
if ($login->access($_SESSION['auth'])) {
} else {
    header("Location: /index.php");
    die;
}
// on instencie notre objet documment

$document = new Crud;

$file = $document->getFile();

// test  des information on été soumie en post
if (empty($_POST)) {
    // je génère un token pour me prémunir des attaques csurf
    $token = new Csrf;
    $tokenDelete = hash('sha256', random_bytes(32));
    $_SESSION['tokenDelete'] = $tokenDelete;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Admin</title>
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
                    <a class="btn btn-danger" aria-current="page" href="/admin/logout.php">LogOut</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container mt-5 ">
        <div class="row ">
            <div class="col-12 col-md-5 mb-5 mt-5 rounded border p-2 me-lg-5">
                <!-- notre formulaire ajoue -->
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 1) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show mb-2" role="alert">
                        Votre Fichier ne coorespond pas
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 2) {
                ?>
                    <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                        Félicitation un fichier à été ajouter
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 3) {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        le fichier a été supprimé
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <h2 class="mt-2"> Add new file</h2>
                <form method="POST" action="/admin/add_fille.php" enctype="multipart/form-data">
                    <input required class="form-control  mt-4" type="file" id="formFile" name="img" />
                    <div id="emailHelp" class="form-text mb-2">file only : pdf, jpeg, png, jpg</div>
                    <div class="col-12  m-auto">
                        <button type="submint" class="btn btn-primary w-100 p-2 mt-2"> Upload</button>
                    </div>
                    <input type="hidden" name="token" value="<?= $token->getToken(); ?>" />
                </form>
            </div>
            <div class="col-12 col-md-6 mt-5 rounded border">
                <!-- notre tableaux element  -->
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th scope="col">File Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($file)) {
                            foreach ($file as $v) { ?>
                                <tr>

                                    <td>
                                        <a class="fw-semibold text-decoration-none" href="./asset/<?= $v->name ?>" download>
                                            <?= $v->name ?>
                                        </a>
                                    </td>
                                    <td>
                                        <form method="post" action="/admin/delete_fille.php">
                                            <button onclick=" return confirm(' Etez-vous sur de vouloir supprimer ')" type="submit" class="btn btn-danger"> <i class="bi bi-trash3-fill"></i> </button>
                                            <input type="hidden" name="id" value="<?= $v->id; ?>" />
                                            <input type="hidden" name="name" value="<?= $v->name; ?>" />
                                            <input type="hidden" name="tokenDelete" value="<?= $tokenDelete; ?>" />
                                            <a type="submit" class="btn btn-primary" href="./asset/<?= $v->name ?>" download> <i class="bi bi-download"></i> </a>
                                        </form>
                                    </td>

                                </tr>
                            <?php }
                        } else {
                            ?>
                    </tbody>
                </table>



                <h3 class="mt-4 text-center"> Il n'y a pas de document pour le momment !</h3>
            <?php
                        }
            ?>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>