<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'zfcuser_role_mapper' => 'ZfcUserAcl\Model\RoleMapper',
                'zfcuseracl_role_tg' => 'Zend\Db\TableGateway\TableGateway',
            ),
            'ZfcAcl\Service\Acl' => array(
                'parameters' => array(
                    'roleProvider' => 'ZfcUserAcl\Service\RoleProvider',
                    'aclLoader' => 'ZfcUserAcl\Service\AclLoader',
                ),
            ),
            'ZfcUserAcl\Service\RoleProvider' => array(
                'parameters' => array(
                    'zfcUserAclService' => 'ZfcUserAcl\Service\ZfcUserAclService',
                ),
            ),
            'ZfcUserAcl\Service\ZfcUserAclService' => array(
                'parameters' => array(
                    'aclService' => 'ZfcAcl\Service\Acl',
                    'userService' => 'ZfcUser\Service\User',
                    'roleMapper' => 'zfcuser_role_mapper',
                ),
            ),

            'zfcuser_role_mapper' => array(
                'parameters' => array(
                    'tableGateway' => 'zfcuseracl_role_tg',
                ),
            ),
            'zfcuseracl_role_tg' => array(
                'parameters' => array(
                    'table' => 'user_role',
                    'adapter' => 'Zend\Db\Adapter\Adapter'
                ),
            ),
        ),
    ),
);
