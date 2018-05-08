<?php
/**
 * Created by PhpStorm.
 * User: jumu
 * Date: 13.03.18
 * Time: 21:48
 */

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'start'));

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
        $menu->addChild('User', array('route' => '#'));
        // you can also add sub level's to your menu's as follows
        $menu['User']->addChild('Register', array('route' => 'fos_user_registration_register'));
        $menu['User']->addChild('Login', array('route' => 'fos_user_security_login'));
        $menu['User']->addChild('Logout', array('route' => 'fos_user_security_logout'));
        // ... add more children

        return $menu;
    }

}