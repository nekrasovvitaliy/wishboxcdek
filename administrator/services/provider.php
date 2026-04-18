<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_wishboxcdek
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\Component\WishboxCdek\Administrator\Extension\WishboxCdekComponent;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new MVCFactory('\\Joomla\\Component\\WishboxCdek'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\Joomla\\Component\\WishboxCdek'));
        $container->registerServiceProvider(new RouterFactory('\\Joomla\\Component\\WishboxCdek'));

        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new WishboxCdekComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));

                return $component;
            }
        );
    }
};
