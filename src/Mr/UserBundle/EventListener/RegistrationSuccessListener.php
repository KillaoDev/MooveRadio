<?php
namespace Mr\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Mr\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class RegistrationSuccessListener implements EventSubscriberInterface {
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents() {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event) {
        /* @var $user User */
        $user = $event->getForm()->getData();
        $user->setAvatar( $user->getCountry() . '.png' );
    }
}