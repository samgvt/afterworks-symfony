<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fkIdx_13", columns={"id_categorie"}), @ORM\Index(name="fkIdx_95", columns={"id_tva"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_produit", type="string", length=45, nullable=false)
     */
    private $libelleProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="id_tva", type="integer", nullable=false)
     */
    private $idTva;

    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     */
    private $idCategorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_produit", type="text", length=65535, nullable=true)
     */
    private $descriptionProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_unitaire_HT", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixUnitaireHt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=true)
     */
    private $image;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="activation", type="boolean", nullable=true, options={"default"="1"})
     */
    private $activation = true;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="import", type="boolean", nullable=true)
     */
    private $import = '0';

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function getLibelleProduit(): ?string
    {
        return $this->libelleProduit;
    }

    public function setLibelleProduit(string $libelleProduit): self
    {
        $this->libelleProduit = $libelleProduit;

        return $this;
    }

    public function getIdTva(): ?int
    {
        return $this->idTva;
    }

    public function setIdTva(int $idTva): self
    {
        $this->idTva = $idTva;

        return $this;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(int $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->descriptionProduit;
    }

    public function setDescriptionProduit(?string $descriptionProduit): self
    {
        $this->descriptionProduit = $descriptionProduit;

        return $this;
    }

    public function getPrixUnitaireHt(): ?float
    {
        return $this->prixUnitaireHt;
    }

    public function setPrixUnitaireHt(float $prixUnitaireHt): self
    {
        $this->prixUnitaireHt = $prixUnitaireHt;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getActivation(): ?bool
    {
        return $this->activation;
    }

    public function setActivation(?bool $activation): self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getImport(): ?bool
    {
        return $this->import;
    }

    public function setImport(?bool $import): self
    {
        $this->import = $import;

        return $this;
    }


}
