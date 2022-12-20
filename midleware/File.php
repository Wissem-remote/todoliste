<?php

Class File{
    public function doc($file)
    {
        $nameFile = htmlentities($file['img']['name']);
        $typeFile = htmlentities($file['img']['type']);
        $sizeFile = $file['img']['size'];
        $tmpFile =  htmlentities($file['img']['tmp_name']);
        $errFile =  $file['img']['error'];
       
        // type que je veux faire passer
        $tab = ['png', 'jpg', 'jpeg','pdf'];
        $type = ['image/png', 'image/jpg', 'image/jpeg', 'application/pdf'];

        // chercher l'extention du ficher grace à la fonction explode appartire du point
        $tabs = explode('.', $nameFile);

        $img = $typeFile;
        $error = null;
        // je vérifie si le type de fichier passé coorespond
        if (in_array($typeFile, $type)) {
            // je fait attention que mon fichier coorespond bien un pdf ou image pas de image.doc.pdf
            if (count($tabs) <= 2 && in_array(strtolower(end($tabs)), $tab)) {
                $img =  $tabs[0] ."-". time() . '.' . strtolower(end($tabs));
                // j'enregistre mon fichier dans mon dosssier asset/
                move_uploaded_file($tmpFile, $_SERVER['DOCUMENT_ROOT'] . '/asset/' . $img);
            } else {
                // si le fichier ne coorespond pas une erreur est trasmie
                $error = "Désoler le fichier est inccorect !";
            }
        } else {
             // si le type fichier ne coorespond pas une erreur est trasmie
            $error = " Le type de votre image ne corespond pas";
        }
        return [$img, $error];
    }
}