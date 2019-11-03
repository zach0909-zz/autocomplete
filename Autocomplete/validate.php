<?php
 
require 'vendor/autoload.php';
 
use App\SQLiteConnection;
 
$db = (new SQLiteConnection())->connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require('createTable.php');

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';

try{
    $query = $db->prepare("SELECT * FROM members WHERE username = ? and password = ?");

} catch(PDOException $e) {
    echo $e->getMessage();
}

$query->execute(array($username, $password));

$result = $query->fetchAll(\PDO::FETCH_ASSOC);

if($result){

    require('homepage.php');
    foreach($result as $ind){
        echo "<p>Hello " . $ind['username'] . ' with ID number: ' . $ind['id'];  
    }
} else {
    echo "not valid";
    require("index.php");
}