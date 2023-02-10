<?php
//  On déclare le namespace de la classe, qui est "Core"
namespace Core;

use Exception;

use GuzzleHttp\Psr7\Response;
use Core\Framework\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Core\Framework\Renderer\PHPRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;


// On déclare la classe "App" qui va contenir la logique pour gérer les requêtes HTTP
class App
{
    private Router $router;
    private array $modules;
    private ContainerInterface $container;
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->router = $container->get(Router::class);
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
        $this->container = $container;
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath(); 
        if (!empty($uri) && $uri[-1] === '/' && $uri != '/') {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
     
        $route = $this->router->match($request);
        if (is_null($route)) {
            return new Response(404, [], "<h2>Cette page existe pas</h2>");
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);


        $response = call_user_func_array($route->getCallback(), [$request]);
        if ($response instanceof ResponseInterface) {
            return $response;
        } elseif (is_string($response)) {
            return new Response(200, [], $response);
        } else {
            throw new Exception("Reponse du serveur invalide");
        }
    }
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
