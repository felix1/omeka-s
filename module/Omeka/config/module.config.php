<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'EntityManager' => 'Omeka\Service\EntityManagerFactory',
            'ApiManager' => 'Omeka\Service\ApiManagerFactory',
            'Logger' => 'Omeka\Service\LoggerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/api/:resource[/:id]',
                    'defaults' => array(
                        'controller' => 'Omeka\Controller\Api\Index',
                    ),
                ),
            ),
             'install' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'     => '/install[/:step]',
                    'defaults'  => array(
                        'controller' => 'Omeka\Controller\Install',
                        'action'     => 'index',
                     ),
                ),       
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Omeka\Controller\Api\Index' => 'Omeka\Controller\Api\IndexController',
            'Omeka\Controller\Install'   => 'Omeka\Controller\Install\InstallController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'api_manager' => array(
        'resources' => array(
            'users' => array(
                'adapter_class' => 'Omeka\Api\Adapter\Entity\User',
            ),
            'vocabularies' => array(
                'adapter_class' => 'Omeka\Api\Adapter\Entity\Vocabulary',
            ),
            'resource_classes' => array(
                'adapter_class' => 'Omeka\Api\Adapter\Entity\ResourceClass',
            ),
            'items' => array(
                'adapter_class' => 'Omeka\Api\Adapter\Entity\Item',
            ),
        ),
    ),
    'entity_manager' => array(
        'conn' => array(
            'user'        => null,
            'password'    => null,
            'dbname'      => null,
            'host'        => null,
            'port'        => null,
            'unix_socket' => null,
            'charset'     => null,
            'driver'      => 'pdo_mysql',
        ),
        'table_prefix' => 'DBPREFIX_',
        'is_dev_mode'  => false,
    ),
    'loggers' => array(
        'application' => array(
            'log' => false,
            'path' => __DIR__ . '/../../../data/logs/application.log',
        ),
        'sql' => array(
            'log' => false,
            'path' => __DIR__ . '/../../../data/logs/sql.log',
        ),
    ),
    'install' => array(
        'tasks' => array(
            'Omeka\Install\Task\Connection',
            'Omeka\Install\Task\Schema',
            'Omeka\Install\Task\UserOne'        
        )        
    )
);
