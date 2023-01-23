<?php
/**
 * *On vérifie si la variable $_POST['marque'] existe. Si elle existe, cela signifie que le formulaire a été soumis
 */
if (isset($_POST['marque'])) {
    // On utilise la fonction var_dump() pour afficher le contenu de la variable $_POST, qui contient toutes les données du formulaire envoyé.
    var_dump($_POST);
    // On utilise la fonction var_dump() pour afficher le contenu de la variable $_FILES, qui contient toutes les informations sur les fichiers envoyés.
    var_dump($_FILES);
    // On crée une variable $imgData qui contiendra les informations sur l'image téléchargée, en utilisant l'index 'img' car c'est le nom donné à l'input pour l'image dans le formulaire
    $imgData = $_FILES['img'];
    // On vérifie si l'erreur de téléchargement de l'image est égale à 0 (ce qui signifie qu'il n'y a pas eu d'erreur).
    if ($imgData['error'] == 0) {
        // On crée une variable $path qui contiendra le chemin où l'image sera enregistrée.
        //  On utilise la fonction dirname() pour obtenir le répertoire parent de celui où se trouve le fichier PHP actuel,
        //  puis on ajoute "/Public/Assets/img/" pour spécifier le sous-répertoire où l'image sera enregistrée.
        $path = dirname(__DIR__) . "/Public/Assets/img/";
        // On crée une variable $temp qui contiendra le chemin temporaire de l'image téléchargée
        $temp = $imgData['tmp_name'];
        // On crée une variable $name qui contiendra le nom de l'image téléchargée
        $name = $imgData['name'];
        // On concatène $path et $name pour obtenir le chemin complet où l'image sera enregistrée.
        $path .= $name;
        // On utilise la fonction move_uploaded_file() pour déplacer l'image téléchargée depuis son emplacement temporaire vers le chemin spécifié par $path
        move_uploaded_file($temp, $path);
        // On utilise la fonction header() pour rediriger l'utilisateur vers la page d'accueil
        header('location:?page=home');
    } else {
        // Si l'erreur de téléchargement de l'image est différente de 0, cela signifie qu'une erreur s'est produite, on affiche un message d'erreur
        echo 'une erreur s\'est produite.';
    }
} else {
    // Si la variable $_POST['marque'] n'existe pas, cela signifie que le formulaire n'a pas été soumis, on affiche donc la page pour ajouter un véhicule en utilisant la fonction require
    require dirname(__DIR__) . "/View/addVehicule.php";
}
