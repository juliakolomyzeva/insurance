<?php
/**
 * Created by PhpStorm.
 * User: jumu
 * Date: 02.05.18
 * Time: 16:31
 */

namespace App\Menu;


use App\Event\Menu\Topbar\UserMenuEvent;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Menu
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var FactoryInterface
     */
    private $factory;
    public function __construct(FactoryInterface $factory, EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
    }
    public function userTopbar(RequestStack $request): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $this->dispatcher->dispatch(
            UserMenuEvent::EVENT,
            new UserMenuEvent($this->factory, $menu, $request)
        );
        return $menu;
    }
}