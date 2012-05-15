<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'zfcuseracl' => 'ZfcUserAcl\Controller\IndexController',
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'zfcuseracl' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);