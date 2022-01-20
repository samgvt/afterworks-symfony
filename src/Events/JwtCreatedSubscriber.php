<?php

namespace App\Events;


// chaque creation du token cette classe sera executer

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;


class JwtCreatedSubscriber
{
    // Abonnement a l'evenement concernant la creation d'un token
    // a chaque creation d'un token (JWTCreatedEvent), la methode onJWTCreated va s'executer
    public function onJWTCreated(JWTCreatedEvent $event) {

        // Ajouter le forstname et le lastname dans le payload

        // 1. Recuperer le user
        $user = $event->getUser();

        // 2. Enrichir le payload
        $payload = $event->getData();
        $payload['prenom'] = $user->getPrenomUtilisateur();
        $payload['nom'] = $user->getNomUtilisateur();

        // 3. Mettre a jour l'evenement avec le nouveau payload
        $event->setData($payload);
    }

}