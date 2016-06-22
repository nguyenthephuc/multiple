<?php

namespace Multiple\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;
use Phalcon\Acl\Adapter\Memory as Acl;

class Module
{
    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'Multiple\Frontend\Controllers' => '../apps/frontend/controllers/',
            'Multiple\Frontend\Models' => '../apps/frontend/models/',
        ));
        $loader->register();
    }
    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices($di)
    {
        //Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            //Attach a event listener to the dispatcher
            $eventManager = new \Phalcon\Events\Manager();
            $eventManager->attach('dispatch', new Acl('frontend'));
            $dispatcher->setDefaultNamespace("Multiple\Frontend\Controllers\\");
            $eventManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {
                //Handle 404 exceptions
                if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
                    $dispatcher->forward(array(
                        'module' => 'frontend',
                        'controller' => 'error',
                        'action' => 'show404'
                    ));
                    return false;
                }
                //Handle other exceptions
                $dispatcher->forward(array(
                    'module' => 'frontend',
                    'controller' => 'error',
                    'action' => 'show503'
                ));
                return false;
            });
            $dispatcher->setEventsManager($eventManager);
            return $dispatcher;
        });
        //Registering the view component
        $di->set('view', function () {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('../apps/frontend/views/');
            $view->setLayoutsDir('../../common/layouts/');
            $view->setPartialsDir('../../common/partials/');
            return $view;
        });
        $di->set('db', function () {
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