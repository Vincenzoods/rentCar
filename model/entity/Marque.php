<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="marque")
 * @ORM\Entity
 */

class Marque
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    private int $id;
    /**
     * @ORM\Column(type="string", name="nom_marque", length="55")
     *
     * @var string
     */
    private string $nom_marque;

    /**
     * @ORM\OneToMany(targetEntity="Vehicule",mappedBy="marque")
     */

    private $vehicules;




    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomMarque.
     *
     * @param string $nomMarque
     *
     * @return Marque
     */
    public function setNomMarque($nomMarque)
    {
        $this->nom_marque = $nomMarque;

        return $this;
    }

    /**
     * Get nomMarque.
     *
     * @return string
     */
    public function getNomMarque()
    {
        return $this->nom_marque;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehicules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add vehicule.
     *
     * @param \Model\Entity\Vehicule $vehicule
     *
     * @return Marque
     */
    public function addVehicule(\Model\Entity\Vehicule $vehicule)
    {
        $this->vehicules[] = $vehicule;

        return $this;
    }

    /**
     * Remove vehicule.
     *
     * @param \Model\Entity\Vehicule $vehicule
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVehicule(\Model\Entity\Vehicule $vehicule)
    {
        return $this->vehicules->removeElement($vehicule);
    }

    /**
     * Get vehicules.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehicules()
    {
        return $this->vehicules;
    }
}
