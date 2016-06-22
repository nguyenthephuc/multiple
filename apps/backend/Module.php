<?php

namespace Multiple\Backend;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;

class Module
{
    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
            'Multiple\Backend\Models'      => '../apps/backend/models/',
            'Multiple\Backend\Plugins'     => '../apps/backend/plugins/',
        ));
        $loader->register();
    }
    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices(DiInterface $di)
    {
        //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers\\");
            return $dispatcher;
        });
        $di->set('session', function() {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        }, true);
        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir('../apps/backend/views/');
            $view->setLayoutsDir('../../common/layouts/');
            $view->setPartialsDir('../../common/partials/');
            return $view;
        });
        //Set a different connection in each module
        $di->set('db', function() {
            return new Database(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "",
                "dbname" => "dbphalcon",
                "charset"=>"utf8",
                "options" => array(
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                )
            ));
        });
    }
}