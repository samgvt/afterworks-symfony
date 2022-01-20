<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="FK_ARTICLE_UTILISATEUR", columns={"id_utilisateur"}), @ORM\Index(name="fkIdx_139", columns={"id_rubrique"})})
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_article", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="text", length=65535, nullable=false)
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false)
     */

    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation_article", type="date", nullable=false)
     */
    private $dateCreationArticle;

    /**
     * @var int
     *
     * @ORM\Column(name="id_rubrique", type="integer", nullable=false)
     */
    private $idRubrique;

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(int $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCreationArticle(): ?\DateTimeInterface
    {
        return $this->dateCreationArticle;
    }

    public function setDateCreationArticle(\DateTimeInterface $dateCreationArticle): self
    {
        $this->dateCreationArticle = $dateCreationArticle;

        return $this;
    }

    public function getIdRubrique(): ?int
    {
        return $this->idRubrique;
    }

    public function setIdRubrique(int $idRubrique): self
    {
        $this->idRubrique = $idRubrique;

        return $this;
    }


}
