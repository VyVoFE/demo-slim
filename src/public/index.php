<?php
require '../app/vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Medoo\Medoo; 
use Slim\App;

//Config setting
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = true;

$config['db']['type'] = "sqlite";
$config['db']['file'] = '../app/db.db';

// Create Slim app with config
$app = new App(["settings" => $config]);

// Get DIC (Dependencies Injection Container)
$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

// Init Medoo
$container['db'] = function ($c){
    $db = $c['settings']['db'];
    $md = new Medoo([
        'database_type' => $db['type'],
        'database_file' => $db['file']
    ]);
    return $md;
};

$app->get('/', function($req, $res){	
    return $res->getBody()->write("Welcome!");
});

//get all records
$app->get('/getAll', function($req, $res){
    $catController = new CatController($this->db);
    $result = $catController->getAll();		
    return $res->withJson($result);
});
//get one record by id
$app->post('/getOne', function($req, $res){
    $body = $req->getParsedBody();
    $catController = new CatController($this->db);
    $result = $catController->getOne($body);		
    return $res->withJson($result);
});
$app->post('/create', function($req, $res){
    $body = $req->getParsedBody();
    $catController = new CatController($this->db);
    $result = $catController->create($body);		
    return $res->withJson($result);
});
//edit a record
$app->post('/update', function($req, $res){
    $body = $req->getParsedBody();
    $catController = new CatController($this->db);
    $result = $catController->update($body);		
    return $res->withJson($result);
});
//delete a record
$app->post('/delete', function($req, $res){
    $body = $req->getParsedBody();
    $catController = new CatController($this->db);
    $result = $catController->delete($body);		
    return $res->withJson($result);
});
$app->run();
?>