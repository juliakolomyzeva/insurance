<?php
// src/Subscriber/UserMenuSubscriber.php

namespace App\Subscriber;

use App\Entity\User;
use App\Event\Menu\Topbar\UserMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

class UserMenuSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TokenStorageInterface $tokenStorage, TranslatorInterface $translator)
    {
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
    }

    public function onUserMenuConfigure(UserMenuEvent $event)
    {
        $menu = $event->getItem();
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        //$dropdown = $menu->addChild(
        //    $this->translator->trans('Hello %username%', ['%username%' => $user->getUsername()], 'usermenu'),
        //    ['dropdown' => true]
        //);
        $menu->setAttribute('class', 'nav nav-justified btn-block');
        $menu->setAttribute('id', 'nav nav-justified btn-block');
        $menu->addChild('Home', array('route' => 'start'));
        $menu['Home']->setAttribute('class', 'header_button');
        /*  // access services from the container!
          $em = $this->container->get('doctrine')->getManager();
          // findMostRecent and Blog are just imaginary examples
          $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();

          $menu->addChild('Latest Blog Post', array(
              'route' => 'blog_show',
              'routeParameters' => array('id' => $blog->getId())
          ));
        */
        // create another menu item
        $admin_dropdown = $menu->addChild(
            $this->translator->trans('Admin functions', []),
            ['dropdown' => true]);
        $menu['Admin functions']->setAttribute('class', 'topmenu_dropdown');
        // you can also add sub level's to your menu's as follows
        $admin_dropdown->addChild(
            $this->translator->trans('Create new category', []));
        $admin_dropdown['Create new category']->setAttribute('class', 'header_button');
        $admin_dropdown->addChild(
            $this->translator->trans('Create new insurance', []));
        $admin_dropdown['Create new insurance']->setAttribute('class', 'header_button');
        $admin_dropdown->addChild(
            $this->translator->trans('Create new user', []),
            ['route' => 'fos_user_registration_register']);
        $admin_dropdown['Create new user']->setAttribute('class', 'header_button');
        $admin_dropdown->addChild(
            $this->translator->trans('Create new provider', []));
        $admin_dropdown['Create new provider']->setAttribute('class', 'header_button');

        $user_dropdown = $menu->addChild(
            $this->translator->trans('User', []),
            ['dropdown' => true]);
        $menu['User']->setAttribute('class', 'topmenu_dropdown');
        // you can also add sub level's to your menu's as follows
        $user_dropdown->addChild(
            $this->translator->trans('Register', []),
            ['route' => 'fos_user_registration_register']);
        $user_dropdown['Register']->setAttribute('class', 'header_button');
        $user_dropdown->addChild(
            $this->translator->trans('Login', []),
            ['route' => 'fos_user_security_login']);
        $user_dropdown['Login']->setAttribute('class', 'header_button');
        $user_dropdown->addChild(
            $this->translator->trans('Logout', []),
            ['route' => 'fos_user_security_logout']);
        $user_dropdown['Logout']->setAttribute('class', 'header_button');
        $user_dropdown->addChild(
            $this->translator->trans('Forgot passwort', []),
            ['route' => 'fos_user_resetting_request']);
        $user_dropdown['Forgot passwort']->setAttribute('class', 'header_button');
    }


    public static function getSubscribedEvents(): array
    {
        return [
            UserMenuEvent::EVENT => 'onUserMenuConfigure',
        ];
    }
}
