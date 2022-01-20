<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fkIdx_110", columns={"id_employe"}), @ORM\Index(name="fkIdx_53", columns={"id_statut"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var int
     *
     * @ORM\Column(name="id_statut", type="integer", nullable=false)
     */
    private $idStatut;

    /**
     * @var int
     *
     * @ORM\Column(name="id_employe", type="integer", nullable=false)
     */
    private $idEmploye;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="datetime", nullable=false)
     */
    private $dateCommande;

    /**
     * @var int
     *
     * @ORM\Column(name="no_table", type="integer", nullable=false)
     */
    private $noTable;

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getIdStatut(): ?int
    {
        return $this->idStatut;
    }

    public function setIdStatut(int $idStatut): self
    {
        $this->idStatut = $idStatut;

        return $this;
    }

    public function getIdEmploye(): ?int
    {
        return $this->idEmploye;
    }

    public function setIdEmploye(int $idEmploye): self
    {
        $this->idEmploye = $idEmploye;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getNoTable(): ?int
    {
        return $this->noTable;
    }

    public function setNoTable(int $noTable): self
    {
        $this->noTable = $noTable;

        return $this;
    }


}
