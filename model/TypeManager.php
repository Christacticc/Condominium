<?php
require_once 'Type.php';

class TypeManager {
    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function db() { return $this->_db; }

    public function add($type)
    {
        $q = $this->_db->prepare('INSERT INTO s_type(ty_id, ty_name) VALUES(:id, :name)');
        $q->bindValue(':id', $type->id());
        $q->bindValue(':name', $type->name());
        $q->execute();
        $type->hydrate(['id' => $this->_db->lastInsertId()]);
        return($type);
    }
    
    public function count()
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_type');
        return (int) $q->fetchColumn();
    }

    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_type WHERE ty_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }

    public function existsWithName($name)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_type WHERE ty_name = :name');
        $q->execute([':name' => $name]);
        return (bool) $q->fetchColumn(); 
    }

    public function get($id)
    {
        $q = $this->_db->prepare('SELECT ty_id id, ty_name name FROM s_type WHERE ty_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $type = new Type($data);
        return($type);
    }

    public function getList()
    {
        $types = [];
        $q = $this->_db->prepare('SELECT ty_name name, ty_id id FROM s_type ORDER BY ty_name');
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $types[] = new Type($data);
        }
        return ($types);
    }

    public function getListExcluded($excluded_types) //renvoie un tableau d'objets types, sauf les types dont le ty_name est dans le tableau $excuded.
    {        
        $types = [];
        $in  = str_repeat('?,', count($excluded_types) - 1) . '?';
        $q = $this->_db->prepare('SELECT ty_name name, ty_id id FROM s_type WHERE ty_name NOT IN (' . $in . ') ORDER BY ty_name');
        $q->execute($excluded_types);
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $types[] = new Type($data);
        }
        return ($types);
    }

    function save($type)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    function update($type)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}

?>
