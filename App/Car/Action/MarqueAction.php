<?php

namespace App\Car\Action;

use Model\Entity\Marque;
use Core\Toaster\Toaster;
use Model\Entity\Vehicule;
use GuzzleHttp\Psr7\Response;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;
use Core\Framework\Renderer\RendererInterface;

class MarqueAction{

    private RendererInterface $renderer;
    private EntityManager $manager;
    private Toaster $toaster;
    private $marqueRepository;
    private $repository;

    public function __construct(RendererInterface $renderer, EntityManager $manager, Toaster $toaster) //injections
    {
        //assignation
        $this->renderer = $renderer;
        $this->manager = $manager;
        $this->toaster = $toaster;
        $this->marqueRepository = $manager->getRepository(Marque::class);
        $this->repository = $manager->getRepository(Vehicule::class);
    }



    public function addMarque(ServerRequestInterface $request)
    {
        $method = $request->getMethod();

        if ($method === 'POST') {
            $data = $request->getParsedBody();
            $marques = $this->marqueRepository->findAll();

            foreach ($marques as $marque) {
                if ($marque->getNomMarque() === $data['marque']) {
                    $this->toaster->makeToast('Cette marque existe déjà',Toaster::ERROR);
                    return $this->renderer->render('@Car/addMarque');
                }
            }
            $new = new Marque();
            $new->setNomMarque($data['marque']);
            $this->manager->persist($new);
            $this->manager->flush();
            $this->toaster->makeToast('Marque crée avec success',Toaster::SUCCESS);
            return (new Response)
                ->withHeader('Location', '/listCar');
        }
        return $this->renderer->render('@Car/addMarque');
    }


    public function listMarque(ServerRequestInterface $request)
    {
        $marques = $this->marqueRepository->findAll();
        return $this->renderer->render('@Car/listMarque', [
            'marques' => $marques
        ]);
    }
   
}