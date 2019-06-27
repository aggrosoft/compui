<?php

require './vendor/autoload.php';
require './lib/Composer.php';

/**
 * Configuration, change at will
 */

ini_set("display_errors",1);

// Show detailed errors, only for debugging
$config['displayErrorDetails'] = true;

// Allow CORS requests from the following domains, configure for more security
$config['allowedRemoteDomains'] = '*';

$appconfig = json_decode(file_get_contents('config.json'), true);

$config = array_merge($appconfig, $config);

/**
 * End of config
 */

/**
 * Setup Slim
 */
$composer = new Composer($appconfig['project-path'], $appconfig['composer-binary']);
$app = new \Slim\App(['settings' => $config, 'composer' => $composer]);
$container = $app->getContainer();

$container['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(dirname(__FILE__) . '/twig', [
        'cache' => false // dirname(__FILE__) . '/cache'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$app->add(new \Slim\HttpCache\Cache('public', 86400));

/**
 * App Routes
 */
$app->get('/', function ($request, $response, $args) {
    $composer = $this->get('composer');
    return $this->view->render($response, 'index.twig', [
        'fileexists' => $composer->composerFileExists(),
        'packages' => $composer->getInstalledPackages(),
        'infos' => $composer->getComposerFile(),
        'composerfile' => $composer->getComposerFile(true),
        'filepath' => $composer->getComposerFilePath(),
        'commands' => $this->get('settings')['allowed-commands']
    ]);
})->setName('home');


$app->post('/savefile', function ($request, $response, $args) {

    $data = $request->getParsedBody();
    $contents = $data['composerfilecontent'];

    if ($contents) {
        $composer = $this->get('composer');
        $composer->saveComposerFile($contents);
    }

    $response = $response->withRedirect($this->router->pathFor('home'),303);
    return $response;

})->setName('savefile');

$app->post('/execute', function ($request, $response, $args) {

    $data = $request->getParsedBody();
    $cmd = $data['cmd'];

    if (in_array($cmd, $this->get('settings')['allowed-commands'])) {
        $composer = $this->get('composer');
        echo '<pre>';
        $composer->runCommand($cmd);
        echo '</pre>';
    }
    //$response = $response->withRedirect($this->router->pathFor('home'),303);
    return $response;

})->setName('execute');

$app->run();
