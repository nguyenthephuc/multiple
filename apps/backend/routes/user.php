<?php

$router->add("/admin/user-list/?{page:[0-9]{0,}}", array(
    'module' => 'backend',
    'controller' => 'user',
    'action' => 'index',
));

$router->add('/admin/user-form/?{id:[0-9]{0,}}', array(
    'module' => 'backend',
    'controller' => 'user',
    'action' => 'form'
));

$router->add('/admin/user-insert', array(
    'module' => 'backend',
    'controller' => 'user',
    'action' => 'insert'
));

$router->add('/admin/user-update', array(
    'module' => 'backend',
    'controller' => 'user',
    'action' => 'update'
));

$router->add('/admin/user-delete', array(
    'module' => 'backend',
    'controller' => 'user',
    'action' => 'delete'
));