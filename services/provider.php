<?php
/**
 * Mod Digi Counter - Service Provider
 *
 * @package     Joomla
 * @subpackage  Modules
 * @license     GNU/GPL, see LICENSE.php
 * @author      Fabrizio Galuppi - Digitest
 * @version     2.0.1
 * @date        Mar 2026
 * @copyright   Copyright (C) 2026 - 2030 Fabrizio Galuppi - Digitest
 * @link        https://www.digitest.net
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->registerServiceProvider(
            new ModuleDispatcherFactory('\\Digitest\\Module\\DigiCounter')
        );
        $container->registerServiceProvider(new Module());
    }
};
