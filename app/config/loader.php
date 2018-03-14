<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->traitsDir,
    ]
);

$namespaces = [];

foreach (glob ($config->application->modelsDir . '*') as $modelDirectory)
{
    $name   = @end (explode ('/', $modelDirectory)); // Ignore 'only variables should be passed'
    $namespaces['Quiz\\' . ucfirst ($name)] = $modelDirectory;
}

$loader->registerNamespaces($namespaces)->register();
