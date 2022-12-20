<?php
// on vérifie si session existe sinom on la crée

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// on appel notre plan qui va nous permetre de faire des opération crud
include "./../midleware/Register.php";



// je test si mes information saisie dans mon formulaire existe
if (!empty($_POST['login']) && !empty($_POST['pass'])) {

    
    // je test si le token coorespond pour me prémunir des attaques csurf
    if (!empty($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {


        // on construie notre objet qui va contenir nos opération CRUD

        $db = new Register();
        
        //je test si mon mot passe contien une Maj une Minuscule et un Chiffre et 14 carractaire recommandation CNIL
        if(preg_match('/(?=[0-9a-zA-Z.*]+$)^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{14,}).*$/', $_POST['pass'])){


            // pour évité les attacque XSS  je htmlentities mes donnée 

            $pw = htmlentities($_POST['pass']);
            $user = htmlentities($_POST['login']);
            // je vérifie si utilisateur éxite ou pas
            $verifed =$db->verified($user);
            if($verifed){
                // hash mon passe word en bcrypt
                $hash = password_hash($pw, PASSWORD_BCRYPT);

                // je enregistre utilisateur dans ma BDD en requete préparé
                $db->createUser($user, $hash);

                // je redirige utilisateur vers l'acceuil avec un messsage 
                header("Location: /index.php?id=1");
                die;
            }else{
                // si le pseaudo exite déja on est rediriger vers le formulaire inscription
                header("Location: /regiter/index.php?id=3");
                die;
            }
            

        }else{
            // si le mot passe ne cooorespond pas je le redirige vers le formulaire inscription
            header("Location: /regiter/index.php?id=1");
            die;
        }
    } else {
        // si le token ne correspond pas je le renvoie dans la page acceuil
        header("Location: /");
        die;
    }
}else{
    // si il y a aucune information saisie dans notre formullaire je le regirige ces le formlurait inscription
    header("Location: /regiter/index.php?id=2");
    die;
}