<?php
//  On déclare le namespace de la classe, qui est "Core"
namespace Core;

use Exception;

// On utilise l'instruction "use" pour utiliser la classe ServerRequestInterface de PSR-7 sans avoir à la préfixer avec son namespace complet
use GuzzleHttp\Psr7\Response;
// On utilise l'instruction "use" pour utiliser la classe ResponseInterface de PSR-7 sans avoir à la préfixer avec son namespace complet
use Core\Framework\Router\Router;
// On utilise l'instruction "use" pour utiliser la classe Response de GuzzleHttp\Psr7 sans avoir à la préfixer avec son namespace complet
use Psr\Http\Message\ResponseInterface;
use Core\Framework\Renderer\PHPRenderer;
use Psr\Http\Message\ServerRequestInterface;


// On déclare la classe "App" qui va contenir la logique pour gérer les requêtes HTTP
class App
{
    private Router $router;
    private array $modules;
    public function __construct(array $modules = [], array $dependencies = [])
    {
        $this->router = new Router();
        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router, $dependencies['renderer']);
        }
    }


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
        if (!empty($uri) && $uri[-1] === '/' && $uri != '/') {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        // $renderer = new PHPRenderer();
        // $path = '../view';
        // $renderer->addPath($path);
        // $response = $renderer->render('test', ['name' => 'Cedric']);

        // return new Response(200, [], $response);



        // $path = '../App/Home/view';
        // $renderer->addGlobal('siteName', 'Mon site global');
        // $renderer->addPath('home', $path);
        // $response = $renderer->render("@home/index");
        $route = $this->router->match($request);
        if (is_null($route)) {
            return new Response(404, [], "<h2>Cette page existe pas</h2>");
        }
        $response = call_user_func_array($route->getCallback(), [$request]);
        if ($response instanceof ResponseInterface) {
            return $response;
        } elseif (is_string($response)) {
            return new Response(200, [], $response);
        } else {
            throw new Exception("Reponse du serveur invalide");
        }
    }
}
