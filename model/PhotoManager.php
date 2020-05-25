<?php
require_once 'Photo.php';

class PhotoManager {

    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
    
    public function db() { return $this->_db; }

    public function add($photo)     {
        $q = $this->_db->prepare('INSERT INTO s_photo(ph_fk_condominium, ph_file_name, ph_position) VALUES (:condominium_id, :file_name, :position)');
        $q->bindValue(':condominium_id', $photo->condominium_id());
        $q->bindValue(':file_name', $photo->file_name());
        $q->bindValue(':position', $photo->position());
        $q->execute();
        
        $condominiumManager = new CondominiumManager($this->_db);
        $condominium = $condominiumManager->get($photo->condominium_id());
        $photo->hydrate([
            'id' => $this->_db->lastInsertId(),
            'condominium_name' => $condominium->name()
        ]);
        return($photo);
    }

    public function count($condominium_id)     {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_photo WHERE ph_fk_condominium = ' . (int) $condominium_id);
        
        return (int) $q->fetchColumn();
    }

    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_photo WHERE ph_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }

    public function get($id)     
    {
            $q = $this->_db->query('SELECT
            p.ph_id id,
            p.ph_file_name file_name,
            p.ph_caption caption,
            p.ph_position position,
            p.ph_fk_condominium condominium_id,
            c.co_name condominium_name
            FROM s_photo p 
            INNER JOIN s_condominium c
            ON p.ph_fk_condominium = c.co_id
            WHERE p.ph_id = ' . $id);
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return new Photo($data);
    }

    public function getList($condominium_id, $start = -1, $limit = -1)
    {
        $photos = [];
        if ($limit == -1)
        {
            $q = $this->_db->prepare('SELECT 
            p.ph_id id,
            p.ph_file_name file_name,
            p.ph_caption caption,
            p.ph_position position,
            p.ph_fk_condominium condominium_id,
            c.co_name condominium_name 
            FROM s_photo p 
            INNER JOIN s_condominium c ON p.ph_fk_condominium = c.co_id
            WHERE p.ph_fk_condominium = ' . $condominium_id .'
            ORDER BY p.ph_position ASC');
        }
        else
        {
            $q = $this->_db->prepare('SELECT 
            p.ph_id id,
            p.ph_file_name file_name,
            p.ph_caption caption,
            p.ph_position position,
            p.ph_fk_condominium condominium_id,
            c.co_name condominium_name 
            FROM s_photo p 
            INNER JOIN s_condominium c ON p.ph_fk_condominium = c.co_id
            WHERE p.ph_fk_condominium = ' . $condominium_id .'
            ORDER BY p.ph_position ASC '. $start .', ' . $limit);
        }
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $photos[] = new Photo($data);
        }
        return ($photos);
    }

    function save($photo)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function update($photo)     {
        $q = $this->_db->prepare('UPDATE s_photo SET ph_file_name = :file_name, ph_position = :position, ph_fk_condominium = :condominium_id WHERE ph_id = :id');
        $q->bindValue(':file_name', $photo->file_name());
        $q->bindValue(':position', $photo->position());
        $q->bindValue(':condominium_id', $photo->condominium_id());
        $q->bindValue(':id', $photo->id());
        $q->execute();
        return($photo);
    }
    
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}

?>
