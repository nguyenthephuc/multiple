<?php

$router->add("/", array(
    'module' => 'frontend',
    'controller' => 'index',
    'action' => 'index',
));

$router->add("/test", array(
    'module' => 'frontend',
    'controller' => 'index',
    'action' => 'test',
));