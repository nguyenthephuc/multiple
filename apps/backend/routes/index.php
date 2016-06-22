<?php

$router->add("/admin/dashboard", array(
    'module' => 'backend',
    'controller' => 'index',
    'action' => 'index',
));

$router->add("/admin/logout", array(
    'module' => 'backend',
    'controller' => 'index',
    'action' => 'logout',
));