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

    public function init(ModuleManager $moduleManager)
    {
        parent::init($moduleManager);
        $this->moduleManager = $moduleManager;
    }
    
    public function bootstrap(ModuleManager $moduleManager, ApplicationInterface $app)
    {
        $locator = $app->getServiceManager();
        $service = $locator->get('ZfcUserAcl\Service\ZfcUserAclService');
        $service->setServiceManager($locator);
        $service->load($moduleManager->events());
    }

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'zfcuseracl_db_adapter' => function($sm) {
                    return $sm->get('Zend\Db\Adapter\Adapter');
                },

                'zfcuseracl_role_tg' => function($sm) {
                    $adapter = $sm->get('zfcuseracl_db_adapter');
                    $tg = new \Zend\Db\TableGateway\TableGateway('user_role', $adapter);
                    return $tg;
                },

                'ZfcUserAcl\Model\RoleMapper' => function($sm) {
                    $mapper = new Model\RoleMapper();
                    $mapper->setTableGateway($sm->get('zfcuseracl_role_tg'));
                    return $mapper;
                },

                'ZfcUserAcl\Service\RoleProvider' => function($sm) {
                    return new Service\RoleProvider;
                },

                'ZfcUserAcl\Service\AclLoaderZendDb' => function ($sm) {
                    $loader = new Service\AclLoaderZendDb;
                    $loader->setRoleMapper($sm->get('ZfcUserAcl\Model\RoleMapper'));
                    $loader->setUserService($sm->get('zfcuser_user_service'));
                    return $loader;
                },

                'zfcacl_service' => function ($sm) {
                    $aclService = $sm->get('ZfcAcl\Service\Acl');
                    $aclService->setAclLoader($sm->get('ZfcUserAcl\Service\AclLoaderZendDb'));
                    $aclService->setRoleProvider($sm->get('ZfcUserAcl\Service\RoleProvider'));
                    return $aclService;
                },

                'ZfcUserAcl\Service\ZfcUserAclService' => function ($sm) {
                    $service = new Service\ZfcUserAclService;
                    $service->setAclService($sm->get('zfcacl_service'));
                    $service->setUserService($sm->get('zfcuser_user_service'));
                    $service->setRoleMapper($sm->get('ZfcUserAcl\Model\RoleMapper'));
                    return $service;
                },
            ),
        );
    }

    public function getDir()
    {
        return __DIR__;
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
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
}
