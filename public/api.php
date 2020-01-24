<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App;
$app->get(
  '/hello/{name}', 
  function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
  }
);

class MyDB extends SQLite3 {
    function __construct() {
        $this->open('customers.db');
    }
}
$db = new MyDB();
if(!$db) {
    echo $db->lastErrorMsg();
    exit();
}
$app->get(
    '/api/participants',
    function (Request $request, Response $response, array $args)  use ($db) {
        $participants=[];
        $sql = "SELECT id, name, surname FROM customer";
        $ret = $db->query($sql);
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
            array_push($participants, ['id' => $row['id'], 'firstname' => $row['name'], 'lastname' => $row['surname']]);
        }
        return $response->withJson($participants);
    }
);
$app->post(
    '/api/participants',
    function (Request $request, Response $response, array $args)  use ($db) {
    $add1 = "INSERT INTO customer (name, surname) VALUES($requestData'firstname'.,$requestData'lastname'.)";
    $add2 = $db->query($add1);
    
    }
);
$app->run();
$db->close();
