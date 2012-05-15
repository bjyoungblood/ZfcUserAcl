<?php

namespace ZfcUserAcl;

use Zend\Module\Manager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\EventManager\StaticEventManager;

class Module implements AutoloaderProvider
{
    protected $zfcUserAclService;

    public function init(Manager $moduleManager)
    {
        $events = $moduleManager->events();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach('bootstrap', 'bootstrap', function($e) {
            $app = $e->getParam('application');
            $locator = $app->getLocator();
            $service = $locator->get('ZfcUserAcl\Service\ZfcUserAclService');

            $manager = $e->getTarget();
            $manager->events()->attach('ZfcAcl\Service\Acl.getAcl', array($service, 'loadAcl'));
        });
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function modulesLoaded($e)
    {
        $this->zfcUserAclService->init();
    }
}
