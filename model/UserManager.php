<?php
require_once 'User.php';

class UserManager {

    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
    

    public function get($id)     
    {
        $q = $this->_db->query('SELECT
        us_id id,
        us_name name,
        us_password password
        FROM s_user 
        WHERE us_id = ' . $id);
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return new User($data);
    }

    function getList($debut = -1, $limite = -1)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function getWithNamePassword($username, $password)
    {
        $q = $this->_db->prepare('SELECT us_id id, us_name name, us_password password FROM s_user WHERE us_name = :us_name AND us_password = :us_password');
        $q->bindValue(':us_name', $username);
        $q->bindValue(':us_password', $password);
        $q->execute();
        
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $user = new User($data);
        return $user;
    }
    
    public function update($user)     {
        $q = $this->_db->prepare('UPDATE s_user SET us_name = :name, us_password = :password WHERE us_id = :id');
        $q->bindValue(':name', $user->name());
        $q->bindValue(':password', $user->password());
        $q->bindValue(':id', $user->id());
        $q->execute();
        return($user);
    }
    
    public function valid($username, $password)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_user WHERE us_name = :us_name AND us_password = :us_password');
        $q->bindValue(':us_name', $username);
        $q->bindValue(':us_password', $password);
        $q->execute();
        
        return (bool) $q->fetchColumn(); 
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}

?>
