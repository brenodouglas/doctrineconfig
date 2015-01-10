<?php
(@include_once  '../vendor/autoload.php') || @include_once  '../../../autoload.php';

define("__APP__", "../app");

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use RespectDoctrine\Doctrine\Doctrine;
use Common\Commands\ServiceCommand;

Doctrine::setConfigDir("../app/config.php");
Doctrine::setIsDevMode(true);

$doctrine = new Doctrine();
$em = $doctrine->getEntityManager();
$helper = ConsoleRunner::createHelperSet($em);

$commands = array();
$commands[] = new ServiceCommand();

ConsoleRunner::run($helper, $commands);
