<?php
// On utilise l'instruction "use" pour utiliser la classe ServerRequest de GuzzleHttp\Psr7 sans avoir à la préfixer avec son namespace complet
use Core\App;
// On utilise l'instruction "use" pour utiliser la classe App de notre projet sans avoir à la préfixer avec son namespace complet
use App\Car\CarModule;
use App\Home\HomeModule;
use GuzzleHttp\Psr7\ServerRequest;
use Core\Framework\Renderer\PHPRenderer;
use Core\Framework\Renderer\TwigRenderer;
use DI\ContainerBuilder;
// On utilise la fonction require pour inclure l'autoloader généré par composer qui va charger les classes utilisées dans notre projet
use function Http\Response\send;


require dirname(__DIR__) . '/vendor/autoload.php';
// On crée une nouvelle instance de la classe App

$modules = [
    HomeModule::class,
    CarModule::class
];
$builder = new ContainerBuilder();

$builder->addDefinitions(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

foreach ($modules as $module) {
    if (!is_null($module::DEFINITIONS)) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}

$container = $builder->build();




$app = new App(
    $container,
    $modules
);

// cli = command line interface
if (php_sapi_name() !== 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());

    send($response);
}

// On appelle la méthode run de notre instance de classe App en passant en paramètre l'objet ServerRequest qui est créé en utilisant la méthode static fromGlobals()
// qui permet de créer un objet ServerRequest en utilisant les variables globales $_GET, $_POST,
