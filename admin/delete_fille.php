<?php

// on appelle notre plan qui va nous permetre de manipuler nos document

include "./../midleware/Crud.php";

// on vérifie si session existe sinom on la crée

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// je test si mes information saisie dans mon formulaire existe
if (!empty($_POST['tokenDelete']) && !empty($_POST['id'])&& !empty($_POST['name'])) {

    
    // je test si le token coorespond pour me prémunir des attaques csurf
    if (!empty($_SESSION['tokenDelete']) && $_SESSION['tokenDelete'] == $_POST['tokenDelete']) {
        
        $document = new Crud;

        $id = htmlentities($_POST['id']);
        $name = htmlentities($_POST['name']);
       
        unlink($_SERVER['DOCUMENT_ROOT'].'/asset/'.$name);
        $document->deleteName($id);
        header("Location: /admin/index.php?id=3");
        die;
    }
}