<?php
require_once 'Postal_code.php';

class Postal_codeManager {

    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }

    function get($id)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    function getList($debut = -1, $limite = -1)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function exists($postal_code)
    {
        $q = $this->_db->query('SELECT count(*) FROM s_postal_code WHERE pc_postal_code = ' . $postal_code)->fetchColumn(); 
        return $q;
    }
    
    public function getCities($postal_code)     {
        $q = $this->_db->prepare('SELECT pc_id id, pc_postal_code postal_code, pc_city city, pc_line_5 line_5 FROM s_postal_code WHERE pc_postal_code = ' . $postal_code);
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $postal_codes[] = new Postal_code($data);
        }
        if(isset($postal_codes))
        {
            return ($postal_codes);
        }
        else 
        {
            throw new Exception($postal_code . ' n\'est pas un code postal existant actuellement');
        }
    }
    
    public function getId($argument)
    {
        $q = $this->_db->prepare('SELECT pc_id FROM s_postal_code WHERE pc_postal_code = :postal_code AND pc_city = :city AND pc_line_5 = :line_5');
        $q->bindValue(':postal_code', $argument['postal_code']);
        $q->bindValue(':city', $argument['city']);
        $q->bindValue(':line_5', $argument['line_5']);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return($data['pc_id']);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
?>
