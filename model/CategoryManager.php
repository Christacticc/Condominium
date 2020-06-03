<?php
require_once 'Category.php';

class CategoryManager {
    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
        
    public function db() { return $this->_db; }
    
    public function add($category)
    {
        $q = $this->_db->prepare('INSERT INTO s_category(ca_id, ca_name, ca_position) VALUES(:id, :name, :position)');
        $q->bindValue(':id', $category->id());
        $q->bindValue(':name', $category->name());
        $q->bindValue(':position', $category->position());
        $q->execute();
        $category->hydrate(['id' => $this->_db->lastInsertId()]);
        return($category);
    }
    
    public function count()
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_category');
        return (int) $q->fetchColumn();
    }    
    
    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_category WHERE ca_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }

    public function existsWithName($name)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_category WHERE ca_name = :name');
        $q->execute([':name' => $name]);
        return (bool) $q->fetchColumn(); 
    }

    public function existUploadedCategory($uploaded_category)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_category WHERE ca_name = :name');
        $q->execute([':name' => $uploaded_category]);
        return (bool) $q->fetchColumn(); 
    }

    public function get($id)     {
        $q = $this->_db->prepare('SELECT ca_id id, ca_name name, ca_position position
        FROM s_category WHERE ca_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $category = new Category($data);
        return($category);
    }

    public function getWithPosition($position)     {
        $q = $this->_db->prepare('SELECT ca_id id, ca_name name, ca_position position
        FROM s_category WHERE ca_position = :position');
        $q->bindValue(':position', $position);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $category = new Category($data);
        return($category);
    }

    public function getList()
    {
        $categories = [];
        $q = $this->_db->prepare('SELECT ca_name name, ca_id id, ca_position position FROM s_category ORDER BY ca_position');
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $categories[] = new Category($data);
        }
        return ($categories);
    }
    
    public function getListExcluded($excluded_categories) //renvoie un tableau d'objets types, sauf les types dont le ty_name est dans le tableau $excuded.
    {        
        $categories = [];
        $in  = str_repeat('?,', count($excluded_categories) - 1) . '?';
        $q = $this->_db->prepare('SELECT ca_name name, ca_id id, ca_position position FROM s_category WHERE ca_name NOT IN (' . $in . ') ORDER BY ca_position');
        $q->execute($excluded_categories);
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $categories[] = new Category($data);
        }
        return ($categories);
    }

    public function maxPosition()
    {
        $q = $this->_db->query('SELECT MAX(ca_position) AS max_position FROM s_category');
        return (int) $q->fetchColumn();
    }

    function save($category)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function update($category)     {
        $q = $this->_db->prepare('UPDATE s_category SET ca_name = :name, ca_position = :position WHERE ca_id = :id');
        $q->bindValue(':name', $category->name());
        $q->bindValue(':position', $category->position());
        $q->bindValue(':id', $category->id());
        $q->execute();
        return($category);
    }
    
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}

?>
