<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Newsletter;
use App\Entity\Rubrique;
use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\NewsletterRepository;
use App\Repository\ProduitRepository;
use App\Repository\RubriqueRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AfterworksController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;



    private ProduitRepository $produitRepository;
    private CategorieRepository $categorieRepository;
    private RubriqueRepository $rubriqueRepository;
    private ArticleRepository $articleRepository;
    private UtilisateurRepository $utilisateurRepository;
    private NewsletterRepository $newsletterRepository;


    // Injection de dépendance
    public function __construct(SerializerInterface $serializer,
                                ValidatorInterface $validator,
                                EntityManagerInterface $entityManager,
                                ProduitRepository $produitRepository,
                                CategorieRepository $categorieRepository,
                                RubriqueRepository $rubriqueRepository,
                                ArticleRepository $articleRepository,
                                UtilisateurRepository $utilisateurRepository,
                                NewsletterRepository $newsletterRepository)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;


        $this->produitRepository = $produitRepository;
        $this->categorieRepository = $categorieRepository;
        $this->rubriqueRepository = $rubriqueRepository;
        $this->articleRepository = $articleRepository;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->newsletterRepository = $newsletterRepository;


    }

    /**
     * @Route("/api/produits", name="api_produit_getproduits", methods={"GET"})
     */

    public function getProduits(): Response
    {
        $produits = $this->produitRepository->findAll();
        $produitsJson = $this->serializer->serialize($produits,'json');
        return new JsonResponse($produitsJson,Response::HTTP_OK,[] ,true);
    }

    /**
     * @Route("/api/produit/{id}", name="api_produit_getproduit", methods={"GET"})
     */
    public function getProduit($id): Response
    {

        $produit = $this->produitRepository->find($id);
        // Tester si le $produit demandé existe
        if (! $produit) {
            // $produit est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "Le produit demandé n'existe pas"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }
        $produitJson = $this->serializer->serialize($produit,'json');
        return new JsonResponse($produitJson,Response::HTTP_OK,[],true);
    }

    // liste de toute les categories
    /**
     * @Route("/api/categories", name="api_categories_getcategories", methods={"GET"})
     */
    public function getCategories(): Response
    {
        $categories = $this->categorieRepository->findAll();
        $categoriesJson = $this->serializer->serialize($categories,'json');
        return new JsonResponse($categoriesJson,Response::HTTP_OK,[] ,true);
    }


    //Obtenir detail d'un categorie
/*    /**
     * @Route("/api/category/{id}", name="api_category_getcategory")
     */
/*    public function getCategory($id): Response
    {

        $category = $this->categorieRepository->find($id);
        // Tester si le $category demandé existe
        if (! $category) {
            // $produit est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "La categorie demandé n'existe pas"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }
        $categoryJson = $this->serializer->serialize($category,'json');
        return new JsonResponse($categoryJson,Response::HTTP_OK,[],true);
    }*/

    //Obtenir detail d'un categorie
       /**
         * @Route("/api/detailRubrique/{id}", name="api_detailRubeique_getdetailrubrique", methods="GET")
         */
        public function getDetailRubrique($id): Response
        {

            $rubrique = $this->rubriqueRepository->find($id);
            // Tester si le $category demandé existe
            if (! $rubrique) {
                // $produit est null
                // Générer une erreur
                $error = [
                    "status" => Response::HTTP_NOT_FOUND,
                    "message" => "La categorie demandé n'existe pas"
                ];
                // Générer une reponse JSON
                return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
            }


            $categoryJson = $this->serializer->serialize($rubrique,'json');
            return new JsonResponse($categoryJson,Response::HTTP_OK,[],true);
        }

    // Obtenir detail d'un categorie
    /**
     * @Route("/api/category/{idCategory}", name="api_category_getcategory", methods={"GET"})
     */
    public function getProductsOfCategory($idCategory): Response
    {

        $category = $this->produitRepository->findBy(array('idCategorie' => $idCategory));
        // Tester
        if (! $category) {
            // $produit est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "La categorie demandé n'existe pas"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }
        $categoryJson = $this->serializer->serialize($category,'json');
        return new JsonResponse($categoryJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route("/api/inscription", name="api_Inscription_createUser", methods={"POST"})
     */
    public function createUser(Request $request) : Response {
        // Récupérer le body de la requête dans lequel se trouve
        // les données au format JSON du nouveau post à insérer
        // Mettre sous surveillance une partie du code


        try {
            $utilisateurJSon = $request->getContent();
            // Désérialiser le json en un objet de la classe Utilisateur
            $utilisateur = $this->serializer->deserialize($utilisateurJSon,Utilisateur::class, "json");

            $responseValidate = $this->validatePost($utilisateur);
            if (! is_null($responseValidate)) {
                return $responseValidate;
            }

            $password = $utilisateur->getPassword();
            $utilisateur->setPassword(password_hash($password, PASSWORD_ARGON2I));

            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->persist($utilisateur); // Préparer l'ordre INSERT
            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($utilisateur,'json');
            return new JsonResponse($postJSon,Response::HTTP_CREATED,[],true);
        } // Intercepter une éventuelle exception
        catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_BAD_REQUEST,[],true);
        }

    }


    private function validatePost(Utilisateur $utilisateur) : ?Response {
        $errors = $this->validator->validate($utilisateur);
        // Tester si il y a des erreurs
        if (count($errors)) {
            // Il y a erreurs
            // Renvoyer les erreurs sous la forme d'une réponse au format JSON
            $errorsJson = $this->serializer->serialize($errors,'json');
            return new JsonResponse($errorsJson,Response::HTTP_BAD_REQUEST,[],true);
        }
        return null;
    }


    // liste de toute les rubriques
    /**
     * @Route("/api/rubriques", name="api_rubriques_getrubriques", methods={"GET"})
     */
    public function getRubriques(): Response
    {
        $rubriques = $this->rubriqueRepository->findAll();
        $rubriquesJson = $this->serializer->serialize($rubriques, 'json');
        return new JsonResponse($rubriquesJson, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/rubrique/{idRubrique}", name="api_rubrique_getarticlerubrique", methods={"GET"})
     */
    public function getArticlesOfRubrique($idRubrique): Response
    {

        $articles = $this->articleRepository->findBy(array('idRubrique' => $idRubrique));
        // Tester
        if (! $articles) {
            // $articles est null
            // Générer une erreur
            $error = "erreur aucun articles";



            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_OK, [], true);
        }

        $categoryJson = $this->serializer->serialize($articles,'json');
        return new JsonResponse($categoryJson,Response::HTTP_OK,[],true);
    }

    /**
     * @Route("/api/article/{id}", name="api_article_getarticle", methods={"GET"})
     */
    public function getArticle($id): Response
    {

        $article = $this->articleRepository->find($id);
        // Tester si le $produit demandé existe
        if (! $article) {
            // $produit est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "Le produit demandé n'existe pas"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }
        $produitJson = $this->serializer->serialize($article,'json');
        return new JsonResponse($produitJson,Response::HTTP_OK,[],true);
    }


    /**
     * @Route("/api/updateArticle/{id}", name="api_updateArticle_updateArticle", methods={"PUT"})
     */
    public function updateArticle(Request $request, $id): Response
    {

        try {
            $requeteJson = $request->getContent();
            $article = $this->articleRepository->find($id);
            // Désérialiser le json en un objet de la classe Article
            $requete = $this->serializer->deserialize($requeteJson, Article::class, "json", ["object_to_populate" => $article]);

            $errors = $this->validator->validate($requete);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }


            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($requete, 'json');
            return new JsonResponse($postJSon, Response::HTTP_CREATED, [], true);


        } catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

        /**
         * @Route("/api/ajoutArticle", name="api_ajoutArticle_updateArticle", methods={"POST"})
         */
        public function createArticle(Request $request): Response
        {

            try {
                $requeteJson = $request->getContent();
                // Désérialiser le json en un objet de la classe Article
                $objetArticle = $this->serializer->deserialize($requeteJson, Article::class, "json");

                $errors = $this->validator->validate($objetArticle);
                // Tester si il y a des erreurs
                if (count($errors)) {
                    // Il y a erreurs
                    // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                    $errorsJson = $this->serializer->serialize($errors, 'json');
                    return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
                }

                // Ajout de l'id Utilisateur avant d'envoyer le json en bdd
                $userID = $this->getUser()->getIdUtilisateur();
                $objetArticle = $objetArticle->setIdUtilisateur($userID);


                // Enregistrer l'objet $post dans la base de données
                $this->entityManager->persist($objetArticle); // Préparer l'ordre INSERT
                $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
                // Renvoyer une réponse HTTP
                $postJSon = $this->serializer->serialize($objetArticle, 'json');
                return new JsonResponse($postJSon, Response::HTTP_CREATED, [], true);


            } catch (NotEncodableValueException $exception) {
                $error = [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "message" => "Le JSON envoyé dans la requête n'est pas valide"
                ];
                // Générer une reponse JSON
                return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
            }
        }



        /**
         * @Route("/api/updateRubrique/{id}", name="api_updateRubrique_updateRubrique", methods={"PUT"})
         */
        public function updateRubrique(Request $request, string $id): Response
    {

        try {
            $requeteJson = $request->getContent();
            $rubrique = $this->rubriqueRepository->find($id);

            // Désérialiser le json en un objet de la classe Article
            $requete = $this->serializer->deserialize($requeteJson, Rubrique::class, "json", ["object_to_populate" => $rubrique]);


            $errors = $this->validator->validate($requete);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }


/*            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->persist($requete); // Préparer l'ordre INSERT*/
            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($requete, 'json');
            return new JsonResponse($postJSon, Response::HTTP_CREATED, [], true);


        } catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    /**
     * @Route("/api/ajoutRubrique", name="api_ajoutRubrique_ajoutRubrique", methods={"POST"})
     */
    public function createRubrique(Request $request): Response
    {

        try {
            $requeteJson = $request->getContent();
            // Désérialiser le json en un objet de la classe Article
            $objetRubrique = $this->serializer->deserialize($requeteJson, Rubrique::class, "json");

            $errors = $this->validator->validate($objetRubrique);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }



            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->persist($objetRubrique); // Préparer l'ordre INSERT
            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($objetRubrique, 'json');
            return new JsonResponse($postJSon, Response::HTTP_CREATED, [], true);


        } catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
        }
    }



    /**
     * @Route("/api/getAllRedac", name="api_ajoutRubrique_updateRubrique", methods={"GET"})
     */
    public function getAllRedac() :Response {


        $utilisateurs = $this->utilisateurRepository->findByRoleThatSucksLess("REDAC");
        if (! $utilisateurs) {
            // $utilisateur est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "Aucun redacteurs"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }

        $utilisateursJson = $this->serializer->serialize($utilisateurs,'json');
        return new JsonResponse($utilisateursJson,Response::HTTP_OK,[],true);


    }

    /**
     * @Route("/api/ajoutRedac", name="api_ajoutRedac_createRedac", methods={"POST"})
     */
    public function createRedac(Request $request) : Response {
        // Récupérer le body de la requête dans lequel se trouve
        // les données au format JSON du nouveau post à insérer
        // Mettre sous surveillance une partie du code


        try {
            $utilisateurJSon = $request->getContent();
            // Désérialiser le json en un objet de la classe Utilisateur
            $utilisateur = $this->serializer->deserialize($utilisateurJSon,Utilisateur::class, "json");

            $responseValidate = $this->validatePost($utilisateur);
            if (! is_null($responseValidate)) {
                return $responseValidate;
            }

            $password = $utilisateur->getPassword();
            $utilisateur->setPassword(password_hash($password, PASSWORD_ARGON2I));

            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->persist($utilisateur); // Préparer l'ordre INSERT
            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($utilisateur,'json');
            return new JsonResponse($postJSon,Response::HTTP_CREATED,[],true);
        } // Intercepter une éventuelle exception
        catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_BAD_REQUEST,[],true);
        }

    }


    /**
     * @Route("/api/detailRedacteur/{id}", name="api_detailRedacteur_getdetailredacteur", methods="GET")
     */
    public function getDetailRedacteur($id): Response
    {

        $redacteur = $this->utilisateurRepository->find($id);
        // Tester si le $category demandé existe
        if (! $redacteur) {
            // $produit est null
            // Générer une erreur
            $error = [
                "status" => Response::HTTP_NOT_FOUND,
                "message" => "Redacteur introuvable"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_NOT_FOUND,[],true);
        }


        $categoryJson = $this->serializer->serialize($redacteur,'json');
        return new JsonResponse($categoryJson,Response::HTTP_OK,[],true);
    }


    /**
     * @Route("/api/updateRedacteur/{id}", name="api_updateRedac_updateRedac", methods={"PUT"})
     */
    public function updateRedacteur(Request $request, $id): Response
    {

        try {
            $requeteJson = $request->getContent();
            $arrayInfo = json_decode($requeteJson, true);


            // verifier si on a le json contient une cle "password"
            if(isset($arrayInfo['password'])){
                // hacher le mdp
                $arrayInfo['password'] = password_hash( $arrayInfo['password'], PASSWORD_ARGON2I);
                $requeteJson = json_encode($arrayInfo);
            }


            $redacteur = $this->utilisateurRepository->find($id);
            // Désérialiser le json en un objet de la classe Article
            $requete = $this->serializer->deserialize($requeteJson, Utilisateur::class, "json", ["object_to_populate" => $redacteur]);

            $errors = $this->validator->validate($requete);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }


            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($requete, 'json');
            return new JsonResponse($postJSon, Response::HTTP_CREATED, [], true);


        } catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    /**
     * @Route("/api/deleteRedacteur/{id}", name="api_deleteRedacteur_deleteRedac", methods={"DELETE"})
     */
    public function deleteRedacteur(int $id) : Response {
        // Récupérer le body de la requête dans lequel se trouve
        // les données au format JSON du nouveau post à insérer
        // Mettre sous surveillance une partie du code


        try {

           $utilisateur = $this->utilisateurRepository->find($id);

            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->remove($utilisateur);
            $this->entityManager->flush();
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($utilisateur,'json');
            return new JsonResponse($postJSon,Response::HTTP_CREATED,[],true);
        } // Intercepter une éventuelle exception
        catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error),Response::HTTP_BAD_REQUEST,[],true);
        }

    }



    /**
     * @Route("/api/Newsletter", name="api_Newsletter_addNewsletter", methods={"POST"})
     */
    public function addNewsletter(Request $request): Response
    {

        try {
            $requeteJson = $request->getContent();
            // Désérialiser le json en un objet de la classe Article
            $objetNewsletter = $this->serializer->deserialize($requeteJson, Newsletter::class, "json");

            $errors = $this->validator->validate($objetNewsletter);
            // Tester si il y a des erreurs
            if (count($errors)) {
                // Il y a erreurs
                // Renvoyer les erreurs sous la forme d'une réponse au format JSON
                $errorsJson = $this->serializer->serialize($errors, 'json');
                return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST, [], true);
            }



            // Enregistrer l'objet $post dans la base de données
            $this->entityManager->persist($objetNewsletter); // Préparer l'ordre INSERT
            $this->entityManager->flush(); // Envoyer l'ordre INSERT vers la base de données
            // Renvoyer une réponse HTTP
            $postJSon = $this->serializer->serialize($objetNewsletter, 'json');
            return new JsonResponse($postJSon, Response::HTTP_CREATED, [], true);


        } catch (NotEncodableValueException $exception) {
            $error = [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "Le JSON envoyé dans la requête n'est pas valide"
            ];
            // Générer une reponse JSON
            return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
        }
    }

}
