<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUtilisateur;


    /**
     * @ORM\Column(name="role_jwt", type="json")
     */
    private  $roles = [];


    /**
     * @var string
     *
     * @ORM\Column(name="nom_utilisateur", type="string", length=45, nullable=false)
     */
    private $nomUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_utilisateur", type="string", length=45, nullable=false)
     */
    private $prenomUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_de_passe", type="text", length=65535, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_utilisateur", type="text", length=65535, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="lib_rue_utilisateur", type="string", length=45, nullable=false)
     */
    private $libRueUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="CP_utilisateur", type="string", length=45, nullable=false)
     */
    private $cpUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_utilisateur", type="string", length=45, nullable=false)
     */
    private $villeUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_utilisateur", type="string", length=45, nullable=false)
     */
    private $telUtilisateur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="abonnement_newsletter", type="boolean", nullable=false)
     */
    private $abonnementNewsletter;







    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): self
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }



    public function getMailUtilisateur(): ?string
    {
        return $this->email;
    }

    public function setMailUtilisateur(string $mailClient): self
    {
        $this->email = $mailClient;

        return $this;
    }

    public function getLibRueUtilisateur(): ?string
    {
        return $this->libRueUtilisateur;
    }

    public function setLibRueUtilisateur(string $libRueUtilisateur): self
    {
        $this->libRueUtilisateur = $libRueUtilisateur;

        return $this;
    }

    public function getCpUtilisateur(): ?string
    {
        return $this->cpUtilisateur;
    }

    public function setCpUtilisateur(string $cpUtilisateur): self
    {
        $this->cpUtilisateur = $cpUtilisateur;

        return $this;
    }

    public function getVilleUtilisateur(): ?string
    {
        return $this->villeUtilisateur;
    }

    public function setVilleUtilisateur(string $villeUtilisateur): self
    {
        $this->villeUtilisateur = $villeUtilisateur;

        return $this;
    }

    public function getTelUtilisateur(): ?string
    {
        return $this->telUtilisateur;
    }

    public function setTelUtilisateur(string $telUtilisateur): self
    {
        $this->telUtilisateur = $telUtilisateur;

        return $this;
    }

    public function getAbonnementNewsletter()
    {
        return $this->abonnementNewsletter;
    }

    public function setAbonnementNewsletter($abonnementNewsletter): self
    {
        $this->abonnementNewsletter = $abonnementNewsletter;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
/*        $password_hash = password_hash($password, PASSWORD_ARGON2I);*/
        $this->password = $password;

        return $this;
    }


    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


}
