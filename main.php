<?php

use SwoftAdmin\Exec\Application;

/** @var Application $app */
$app = include __DIR__."/exec/bootstrap.php";

$app->run($argv);
