<?php

$router->add("/admin/login/([0-9]{4})([0-9]{2})([0-9]{2})", array(
    'module' => 'backend',
    'controller' => 'login',
    'action' => 'index',
));