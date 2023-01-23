<?php
// On utilise l'instruction "use" pour utiliser la classe ServerRequest de GuzzleHttp\Psr7 sans avoir à la préfixer avec son namespace complet
use GuzzleHttp\Psr7\ServerRequest;
// On utilise l'instruction "use" pour utiliser la classe App de notre projet sans avoir à la préfixer avec son namespace complet
use Core\App;
// On utilise la fonction require pour inclure l'autoloader généré par composer qui va charger les classes utilisées dans notre projet
use function Http\Response\send;

require dirname(__DIR__) . '/vendor/autoload.php';
// On crée une nouvelle instance de la classe App
$app = new App();

// On appelle la méthode run de notre instance de classe App en passant en paramètre l'objet ServerRequest qui est créé en utilisant la méthode static fromGlobals()
// qui permet de créer un objet ServerRequest en utilisant les variables globales $_GET, $_POST,
$response = $app->run(ServerRequest::fromGlobals());

send($response);
