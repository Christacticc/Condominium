<?php
require_once 'Address.php';

class AddressManager {

    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
        
    public function getId($argument)
    {
        $q = $this->_db->prepare('SELECT ad_id FROM s_address WHERE ad_part_1 = :part_1 AND ad_part_2 = :part_2 AND ad_fk_postal_code_id = :postal_code_id');
        $q->bindValue(':part_1', $argument['part_1']);
        $q->bindValue(':part_2', $argument['part_2']);
        $q->bindValue(':postal_code_id', $argument['postal_code_id']);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return($data['ad_id']);
    }
        
    public function add($address)     {
        $q = $this->_db->prepare('INSERT INTO s_address(ad_part_1, ad_part_2, ad_fk_postal_code_id) VALUES(:part_1, :part_2, :postal_code_id)');
        $q->bindValue(':part_1', $address->part_1());
        $q->bindValue(':part_2', $address->part_2());
        $q->bindValue(':postal_code_id', $address->postal_code_id());
        $q->execute();
        $address->hydrate(['id' => $this->_db->lastInsertId()]);
        return($address);
    }

    function count()     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_address WHERE ad_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }


    function get($id)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    function getList($debut = -1, $limite = -1)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    function save($address)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    function update($address)
    {
        $q = $this->_db->prepare('UPDATE s_address SET ad_part_1 = :part_1, ad_part_2 = :part_2, ad_fk_postal_code_id = :postal_code_id WHERE ad_id = :id');
        
        $q->bindValue(':part_1', $address->part_1(), PDO::PARAM_STR);
        $q->bindValue(':part_2', $address->part_2(), PDO::PARAM_STR);
        $q->bindValue(':postal_code_id', $address->postal_code_id(), PDO::PARAM_INT);
        $q->bindValue(':id', $address->id(), PDO::PARAM_INT);
        
        $q->execute();

    }
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
    
}

?>
