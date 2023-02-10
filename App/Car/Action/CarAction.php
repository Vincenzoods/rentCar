<?php

namespace App\Car\Action;

use Model\Entity\Marque;
use Core\Toaster\Toaster;
use Model\Entity\Vehicule;
use GuzzleHttp\Psr7\Response;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;
use Core\Framework\Renderer\RendererInterface;
use Core\Framework\Validator\Validator;

class CarAction
{
    //declaration
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

    /**
     * Methode ajoutant un vehicule en bdd
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function addCar(ServerRequestInterface $request)
    {
        $method = $request->getMethod();

        if ($method === 'POST') {
            $data = $request->getParsedBody();
            $validator = new Validator($data);
            $errors = $validator
                ->required('modele', 'couleur', 'marque')
                ->getErrors();
            if ($errors) {
                foreach ($errors as $error) {
                    $this->toaster->makeToast($error->toString(), Toaster::ERROR);
                }
                return (new Response())
                    ->withHeader('Location', '/addCar');
            }
            $new = new Vehicule();
            $marque = $this->marqueRepository->find($data['marque']);
            if ($marque) {
                $new->setModel($data['modele'])
                    ->setMarque($marque)
                    ->setCouleur($data['color']);

                //persist = "prepare()"
                $this->manager->persist($new);
                //flush = execute();
                $this->manager->flush();
                $this->toaster->makeToast('Véhicule crée avec success', Toaster::SUCCESS);
            }
            return (new Response)
                ->withHeader('Location', '/listCar');
        }

        $marques = $this->marqueRepository->findAll();
        return $this->renderer->render('@Car/addCar', ['marques' => $marques]);
    }


    /**
     * Methode affichant une liste de vehicules en bdd
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function listCar(ServerRequestInterface $request): string
    {
        $voitures = $this->repository->findAll();

        return $this->renderer->render('@Car/listCar', [
            "voitures" => $voitures
        ]);
    }

    /**
     * Methode retournant le detail d'un vehicule en bdd
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function infoCar(ServerRequestInterface $request): string
    {
        $id = $request->getAttribute('id');
        $voiture = $this->repository->find($id);
        return $this->renderer->render('@Car/infoCar', [
            "voiture" => $voiture
        ]);
    }
    /**
     * Methode modifiant un vehicule en bdd
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function update(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $voiture = $this->repository->find($id);
        $method = $request->getMethod();

        if ($method === 'POST') {
            $data = $request->getParsedBody();
            $marque = $this->marqueRepository->find($data['marque']);
            $voiture->setModel($data['modele'])
                ->setMarque($marque)
                ->setCouleur($data['color']);
            $this->manager->flush();
            $this->toaster->makeToast('Modif success', Toaster::SUCCESS);
            return (new Response)
                ->withHeader('Location', '/listCar');
        }
        $marques = $this->marqueRepository->findAll();

        $id = $request->getAttribute('id');
        $voiture = $this->repository->find($id);
        return $this->renderer->render(
            '@Car/updateCar',
            [
                "voiture" => $voiture,
                "marques" => $marques
            ]
        );
    }
    /**
     * Methode supprimant un vehicule en bdd
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function delete(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $voiture = $this->repository->find($id);
        $this->manager->remove($voiture);
        $this->manager->flush();
        $this->toaster->makeToast('Supprimer avec success', Toaster::SUCCESS);
        return (new Response())
            ->withHeader('Location', '/listCar');
    }
}
