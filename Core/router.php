<?php
// On vérifie si la variable $_GET['page'] existe. Si elle existe, cela signifie que l'utilisateur a demandé une page particulière
if (isset($_GET['page'])) {
    // On crée une variable $page qui contiendra le nom de la page demandée. On utilise la variable $_GET['page'] pour récupérer la valeur.
    $page = $_GET['page'];
    // On utilise un "switch" pour vérifier la valeur de la variable $page
    switch ($page) {
        // Si la valeur est "addVehicule", on inclut le fichier "addVehiculeController.php" qui contient le code pour gérer la page d'ajout de véhicule
        case 'addVehicule':
            include dirname(__DIR__) . '/Controller/addVehiculeController.php';
            break;
            // Si la valeur est "home", on ne fait rien
        case 'home':
            break;
    }
    // Si la variable $_GET['page'] n'existe pas, cela signifie que l'utilisateur a demandé la page d'accueil. Il faudrait inclure le fichier approprié pour afficher cette page
} else {
    //Inclure home page

}
