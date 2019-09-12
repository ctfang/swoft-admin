<?php

use Swoft\SwoftAdmin\Exec\Console\Console;
use Swoft\SwoftAdmin\Exec\Console\Controller;
use Swoft\SwoftAdmin\Exec\Console\Middleware;
use Swoft\SwoftAdmin\Exec\Console\Model;
use Swoft\SwoftAdmin\Exec\Console\Postmen;
use Swoft\SwoftAdmin\Exec\Loader;
use Swoft\SwoftAdmin\Model\Dao\AnnotationResource;

require_once __DIR__."/Exec/Loader.php";


Loader::addRoute("routes",[Controller::class,"getRoutes"]);
Loader::addRoute("control/list",[Controller::class,"getControllers"]);
Loader::addRoute("control/add",[Controller::class,"addControllers"]);
Loader::addRoute("mids",[Middleware::class,"getMiddleware"]);
Loader::addRoute("mids/add",[Middleware::class,"addMiddleware"]);
Loader::addRoute("model/dao",[Model::class,"dao"]);
Loader::addRoute("model/data",[Model::class,"data"]);
Loader::addRoute("model/logic",[Model::class,"logic"]);
Loader::addRoute("model/addClass",[Model::class,"addClass"]);

Loader::addRoute("console/command",[Console::class,"command"]);
Loader::addRoute("console/add",[Console::class,"add"]);
Loader::addRoute("postmen",[Postmen::class,"down"]);


Loader::run($argv);
