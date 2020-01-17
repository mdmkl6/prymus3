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
$sql = "SELECT id, name, surname FROM customer";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
    echo "id = ". $row['id'] . ", ";
    echo "name = ". $row['name'] . ", ";
    echo "surname = ". $row['surname'] ."<br>";
}
$app->get(
    '/api/participants',
    function (Request $request, Response $response, array $args)  use ($db) {
        $array = [];
        $array[] = 'element';
        return $response->withJson($array);
    }
);
$app->run();
$db->close();
