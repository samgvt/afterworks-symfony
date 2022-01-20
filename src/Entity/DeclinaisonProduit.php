<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeclinaisonProduit
 *
 * @ORM\Table(name="declinaison_produit", indexes={@ORM\Index(name="fkIdx_156", columns={"id_declinaison"}), @ORM\Index(name="fkIdx_159", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\DeclinaisonProduitRepository")
 */
class DeclinaisonProduit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_declinaison_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idDeclinaisonProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="id_declinaison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idDeclinaison;

    /**
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idProduit;

    public function getIdDeclinaisonProduit(): ?int
    {
        return $this->idDeclinaisonProduit;
    }

    public function getIdDeclinaison(): ?int
    {
        return $this->idDeclinaison;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }


}
