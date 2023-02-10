<?php

namespace App\Car;

use Model\Entity\Marque;
use Core\Toaster\Toaster;
use Model\Entity\Vehicule;
use App\Car\Action\CarAction;
use GuzzleHttp\Psr7\Response;
use Doctrine\ORM\EntityManager;
use App\Car\Action\MarqueAction;
use Core\Framework\Router\Router;
use Core\Session\SessionInterface;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Core\Framework\Renderer\RendererInterface;
use Core\Framework\AbstractClass\AbstractModule;

class CarModule
{   //declaration
    private SessionInterface $session;
    private Router $router;
    private RendererInterface $renderer;
    private $repository;
    private $marqueRepository;
    private EntityManager $manager;
    private Toaster $toaster;
    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

    public function __construct(ContainerInterface $container)
    {   
   
        $this->router = $container->get(Router::class);
        $this->renderer = $container->get(RendererInterface::class);
        $carAction = $container->get(CarAction::class);
        $marqueAction = $container->get(MarqueAction::class);
        
        $this->renderer->addPath('Car', __DIR__ . DIRECTORY_SEPARATOR . 'view');
        $this->router->get('/addCar', [$carAction, 'addCar'], 'car.addCar');
        $this->router->get('/listCar', [$carAction, 'listCar'], 'car.listCar');
        $this->router->get('/infoCar/{id:[\d]+}', [$carAction, 'infoCar'], 'car.infoCar');
        $this->router->get('/update/{id:[\d]+}', [$carAction, 'update'], 'car.update');
        $this->router->post('/update/{id:[\d]+}', [$carAction, 'update'], 'car.update');
        $this->router->get('/delete/{id:[\d]+}', [$carAction, 'delete'], 'car.delete');
        $this->router->post('/addCar', [$carAction, 'addCar']);
        $this->router->get('/addMarque', [$marqueAction, 'addMarque'], 'marque.add');
        $this->router->post('/addMarque', [$marqueAction, 'addMarque']);
        $this->router->get('/listMarque', [$marqueAction, 'listMarque'], 'marque.listMarque');
    }
   
}
