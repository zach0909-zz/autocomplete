<?php
namespace App;
 
class SQLiteConnection {
   
    private $pdo;
 
    /***
     * @return \PDO
     */
    public function connect() {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:db/whatever.sqlite");
        }
        return $this->pdo;
    }
}