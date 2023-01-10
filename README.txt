Bonjour,

1 - J'ai normalement créé toutes les demandes voulues pour ce test en php version 7.4.

2 - J'ai aussi créé une page inscription, car j'ai voulu hash le mot passe en b-cript pour une meilleure sécurité
    même si vous avez indiqué que ce n'était pas nécessaire.

3 - Pour s'inscrire sur le site, il vous faudra fournir un pseudo et mot-passe qui doit contenir 
    14 caractères, une majuscule, une minuscule et un chiffre, c'est l'une des deux recommandations de mot passe de la CNIL.

4 - L'utilisateur ne peut pas s'inscrire deux fois avec le même pseudo ou email.

5 - Toutes les requêtes SQL son préparé et les données sont échappées avec la fonction htmlentities pour me prémunir des injections SQL et faille XSS.

6 - Tous les formulaires contiennent des Token pour me prémunir des attaques csurf formulaire Login/Sign-Up//upload-file/delete-file

7 - Aussi, vous pouvez Uploader que des fichiers pdf, jpeg, png, jpg.

8 - La base donnée est en ligne et un fichier SQL se trouve dans le dossier SQL, vous n'avez rien à modifier si vous souhaitez.

9 - Si vous souhaitez changer les informations BDD, il faudra les modifier le fichier env.php.

login1 : test@test.com 
login2 : admin@admin.com

MP1 : Wissem 
MP2 : Wissem

10 - Le site web est déployé en ligne et vous pouvez aussi le tester directement en ligne.

lien : http://app-2b7813a0-887d-48df-b8c8-15fa3f608d6f.cleverapps.io/

Normalement tout fonctionne correctement, car j'ai tout testé en ligne et en local en PHP 7.4.

Bon test et n'existez pas revenir vers moi si vous avez des recommandations ou des questions.

Run : php -S localhost:8000 
