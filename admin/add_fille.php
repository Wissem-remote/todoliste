<?php
// on appelle notre plan qui va nous permetre de uploader un image

include "./../midleware/File.php";


// on appelle notre plan qui va nous permetre de manipuler nos document

include "./../midleware/Crud.php";

// on vérifie si session existe sinom on la crée

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// on verifie si l'image à été uploader
if (!empty($_FILES['img'])) {
    // je test si le token coorespond pour me prémunir des attaques csurf
    if (!empty($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {
        // on instencie notre objet documment

        $document = new Crud;

        // on instencie notre objet File

        $image = new File;
        $op = $image->doc($_FILES);
        $pic = $op[0];
        $error = $op[1];

        // si un message sort du traiment de fichier
        if (!empty($error)) {
            header("Location: /admin/index.php?id=1");
            die;
        }else{
            $document->addDocument($pic);
            header("Location: /admin/index.php?id=2");
            die;
        }
    }
}