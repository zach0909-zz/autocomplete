<?php
 
require 'vendor/autoload.php';
 
use App\SQLiteConnection;
 
$db = (new SQLiteConnection())->connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
$db->query("CREATE TABLE IF NOT EXISTS members (
            id INT PRIMARY KEY, 
            username VARCHAR(52),
            password VARCHAR(12))");

} catch(PDOException $e) {
    echo $e->getMessage();
}

$count_object= $db->query("SELECT count(*) from members");
$count = $count_object->fetch();

if(!$count[0]){
    $db->exec("INSERT INTO members (id, username, password) VALUES (1, 'firstguy', 'password1')");
    $db->exec("INSERT INTO members (id, username, password) VALUES (2, 'secondguy', 'password2')");
    $db->exec("INSERT INTO members (id, username, password) VALUES (3, 'thirdguy', 'password3')");
}
