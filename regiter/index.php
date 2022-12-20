<?php


// notre plan qui va nous permetre de généré un token
include "./../midleware/Csrf.php";

// test  des information on été soumie en post
if (empty($_POST)) {
    // je génère un token pour me premunir des attaques csurf
    $token = new Csrf;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Sign Up</title>
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
                    <a class="nav-link active" aria-current="page" href="/regiter/">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container mt-5 ">
        <div class="row ">
            <div class="col-11 col-md-7 m-auto border rounded   p-3">
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 2) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Veuillez renseigner vos information.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 1) {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ce password ne correspond pas
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <?php
                if (!empty($_GET['id']) && $_GET['id'] == 3) {
                ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        Ce pseaudo existe déja
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <h1> Please sign up :</h1>
                <form method="post" action="/regiter/add.php">
                    <div>
                        <input type="text" name="login" class="form-control mt-4 mb-4" placeholder="Login" required />
                        <input type="password" name="pass" class="input form-control mb-4" placeholder="Password" required />
                    </div>
                    <div class="col-5 col-lg-2 m-auto">
                        <button class="btn btn-success w-100 p-2 " type="submit"> Sign Up</button>
                    </div>
                    <input type="hidden" name="token" value="<?= $token->getToken(); ?>" />
                </form>
            </div>
        </div>
    </main>


    <script src="/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>