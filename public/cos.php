<?php
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
/*
$tab = "CREATE TABLE `customer` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT,
    `surname` TEXT,
    `email` TEXT
)";
$tm = $db->query($tab);
*/

$sql = "SELECT id, name, surname FROM customer";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
    echo "id = ". $row['id'] . ", ";
    echo "name = ". $row['name'] . ", ";
    echo "surname = ". $row['surname'] ."<br>";
}
$add1 = "INSERT INTO customer (name, surname)
    VALUES('Bogusław', 'Krzak')";
$add2 = $db->query($add1);
$db->close();
