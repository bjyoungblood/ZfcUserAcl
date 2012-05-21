<?php

namespace ZfcUserAcl;

use Zend\ModuleManager\ModuleManager,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface, 
    Zend\Mvc\ApplicationInterface,
    ZfcBase\Module\ModuleAbstract;

class Module extends ModuleAbstract implements 
    AutoloaderProviderInterface, 
    ConfigProviderInterface, 
    ServiceProviderInterface
{
    protected $zfcUserAclService;

    public function bootstrap(ModuleManager $manager, ApplicationInterface $app)
    {
        $locator = $app->getServiceManager();
        $service = $locator->get('ZfcUserAcl\Service\ZfcUserAclService');
        $manager->events()->attach('ZfcAcl\Service\Acl.loadStaticAcl', array($service, 'loadAcl'));
        $manager->events()->attach('ZfcAcl\Service\Acl.loadResource', array($service, 'loadResource'));
    }

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'ZfcUserAcl\Service\ZfcUserAclService' => function ($sm) {
                    $service = new Service\ZfcUserAclService;
                    return $service;
                },
            ),
        );
    }

    public function modulesLoaded($e)
    {
        $this->zfcUserAclService->init();
    }

    public function getDir()
    {
        return __DIR__;
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }
     
}
