<?php
//  On déclare le namespace de la classe, qui est "Core"
namespace Core;

use Core\Framework\Renderer\PHPRenderer;

// On utilise l'instruction "use" pour utiliser la classe ServerRequestInterface de PSR-7 sans avoir à la préfixer avec son namespace complet
use Psr\Http\Message\ServerRequestInterface;
// On utilise l'instruction "use" pour utiliser la classe ResponseInterface de PSR-7 sans avoir à la préfixer avec son namespace complet
use Psr\Http\Message\ResponseInterface;
// On utilise l'instruction "use" pour utiliser la classe Response de GuzzleHttp\Psr7 sans avoir à la préfixer avec son namespace complet
use GuzzleHttp\Psr7\Response;


// On déclare la classe "App" qui va contenir la logique pour gérer les requêtes HTTP
class App
{
    // On déclare la méthode "run" qui va gérer les requêtes HTTP
    //  Elle prend en paramètre un objet ServerRequestInterface qui contient les informations sur la requête HTTP.
    //  Elle retourne un objet ResponseInterface qui contiendra les informations sur la réponse HTTP
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        // On crée une variable $uri qui contiendra le chemin de la requête.
        //  On utilise la méthode getUri() de l'objet ServerRequestInterface pour récupérer l'objet UriInterface qui contient les informations sur l'URI de la requête,
        //   puis on utilise la méthode getPath() de cet objet pour récupérer le chemin de la requête
        $uri = $request->getUri()->getPath();
        // On vérifie si la variable $uri n'est pas vide et si le dernier caractère du chemin est un slash "/" et si le chemin n'est pas égal à "/" .
        //  Si c'est le cas, on crée une nouvelle instance de la classe Response et on utilise les méthodes withStatus() et withHeader() pour ajouter un statut "301" et une en-tête "Location"
        //   avec la valeur du chemin sans le dernier caractère qui est un slash
        if (!empty($uri) && $uri[-1] === '/' && $uri != '/rentcarcour/public/') {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        $renderer = new PHPRenderer();
        // $path = '../view';
        // $renderer->addPath($path);
        // $response = $renderer->render('test', ['name' => 'Cedric']);

        // return new Response(200, [], $response);



        $path = '../App/Home/view';
        $renderer->addGlobal('siteName', 'Mon site global');
        $renderer->addPath('home', $path);
        $response = $renderer->render("@home/index");

        return new Response(200, [], $response);
    }
}
