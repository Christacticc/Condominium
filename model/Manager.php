<?php

class Manager {
    const HOST = 'localhost';
    const NAME = 'sagnimorte_db';
    const USER = 'root';
    const PASSWORD = 'root';
    
    public function dbConnect()
    {
        $db = new \PDO('mysql:host='localhost';dbname='.self::NAME.';charset=utf8', self::USER, self::PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        return($db);
        trigger_error('Not Implemented!', E_USER_WARNING);
    }
}