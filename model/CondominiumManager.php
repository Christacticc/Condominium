<?php
require_once 'Condominium.php';

class CondominiumManager {
    
    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
    
    public function db() { return $this->_db; }
        
    public function add($condominium)
    {
        // 1) Récupérer l'id du code postal.
        $postal_code_manager = new Postal_codeManager($this->_db);
        $param_pc['postal_code'] = $condominium->postal_code();
        $param_pc['city'] = $condominium->city();
        $param_pc['line_5'] = $condominium->line_5();
        $postal_code = new Postal_code($param_pc);
        $postal_code_id = $postal_code_manager->getId($param_pc);

        // 2) Chercher si l'adresse existe déjà, récupérer son id. 
        $address_manager = new AddressManager($this->_db);
        $param_ad['part_1'] = $condominium->address_1();
        $param_ad['part_2'] = $condominium->address_2();
        $param_ad['postal_code_id'] = $postal_code_id;
        $address = new Address($param_ad);
        
        $address_id = $address_manager->getId($param_ad);
        
        if (empty($address_id)) // Sinon, la créer, récupérer son id.
        {
            $address = $address_manager->add($address);
            $address_id = $address->id();
        }
        
        // 3) Créer la nouvelle copropriété.
        $q = $this->_db->prepare('INSERT INTO 
        s_condominium(co_name, co_fk_address_id, co_internal_reference, co_password) VALUES(:name, :address_id, :internal_reference, :password)');
        $q->bindValue(':name', $condominium->name());
        $q->bindValue(':address_id', $address_id);
        $q->bindValue(':internal_reference', $condominium->internal_reference());
        $q->bindValue(':password', $condominium->password());
        $q->execute();
        
        $condominium->hydrate([
            'id' => $this->_db->lastInsertId(),
            'address_id' =>$address_id,
            'code_postal_id' => $postal_code_id,
            'message' => ''
         ]);
        return($condominium);
        
    }

    function count()
    {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_condominium WHERE co_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }

    public function exists($id)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_condominium WHERE co_id = :id');
        $q->execute([':id' => $id]);
        
        return (bool) $q->fetchColumn(); 
    }
    
    public function existsName($name)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_condominium WHERE co_name = :name');
        $q->execute([':name' => $name]);
        
        return $q->fetchColumn(); 
    }
    
    public function countAddress_id($address_id)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_condominium WHERE co_fk_address_id = :address_id');
        $q->execute([':address_id' => $address_id]);
        
        return (int) $q->fetchColumn();
    }
    
    
    
    public function existsInternal_reference($internal_reference)
    {
            return $this->_db->query('SELECT COUNT(*) FROM s_condominium WHERE co_internal_reference = '. $internal_reference)->fetchColumn();
    }

    public function get($id)
    {
        $q = $this->_db->query('SELECT p.pc_postal_code postal_code, p.pc_city city, p.pc_line_5 line_5, a.ad_part_1 address_1, a.ad_part_2 address_2 , a.ad_fk_postal_code_id postal_code_id, c.co_id id, c.co_name name, c.co_fk_address_id address_id, c.co_internal_reference internal_reference, c.co_message message, c.co_password password FROM s_postal_code p INNER JOIN s_address a ON a.ad_fk_postal_code_id = p.pc_id INNER JOIN s_condominium c ON c.co_fk_address_id = a.ad_id WHERE c.co_id = ' . $id);
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return new Condominium($data);
    }

    public function getListWithEntry($entry)
    {
        $condominiums = [];
        $q = $this->_db->prepare('SELECT p.pc_postal_code postal_code, p.pc_city city, p.pc_line_5 line_5, a.ad_part_1 address_1, a.ad_part_2 address_2 , a.ad_fk_postal_code_id postal_code_id, c.co_id id, c.co_name name, c.co_fk_address_id address_id, c.co_internal_reference internal_reference, c.co_message message, c.co_password password FROM s_postal_code p INNER JOIN s_address a ON a.ad_fk_postal_code_id = p.pc_id INNER JOIN s_condominium c ON c.co_fk_address_id = a.ad_id WHERE c.co_name LIKE "%' . $entry . '%" OR a.ad_part_1 LIKE "%' . $entry . '%" OR a.ad_part_2 LIKE "%' . $entry . '%" OR p.pc_postal_code LIKE "%' . $entry . '%" OR p.pc_city LIKE "%' . $entry . '%"');
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $condominiums[] = new Condominium($data);
        }
        return ($condominiums);
    }

    public function getWithNamePassword($name, $password)
    {
        $q = $this->_db->query('SELECT p.pc_postal_code postal_code, p.pc_city city, p.pc_line_5 line_5, a.ad_part_1 address_1, a.ad_part_2 address_2 , a.ad_fk_postal_code_id postal_code_id, c.co_id id, c.co_name name, c.co_fk_address_id address_id, c.co_internal_reference internal_reference, c.co_message message, c.co_password password FROM s_postal_code p INNER JOIN s_address a ON a.ad_fk_postal_code_id = p.pc_id INNER JOIN s_condominium c ON c.co_fk_address_id = a.ad_id WHERE c.co_name = "' . $name . '" AND c.co_password = "' . $password . '"');
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return new Condominium($data);
    }

    public function getList($start = -1, $limit = -1)
    {
        $condominiums = [];
        if ($limit == -1)
        {

            $q = $this->_db->prepare('SELECT p.pc_postal_code postal_code, p.pc_city city, p.pc_line_5 line_5, a.ad_part_1 address_1, a.ad_part_2 address_2 , a.ad_fk_postal_code_id postal_code_id, c.co_id id, c.co_name name, c.co_fk_address_id address_id, c.co_internal_reference internal_reference, c.co_message message, c.co_password password FROM s_postal_code p INNER JOIN s_address a ON a.ad_fk_postal_code_id = p.pc_id INNER JOIN s_condominium c ON c.co_fk_address_id = a.ad_id ORDER BY co_name');
        }
        else
        {
            $q = $this->_db->prepare('SELECT p.pc_postal_code postal_code, p.pc_city city, p.pc_line_5 line_5, a.ad_part_1 address_1, a.ad_part_2 address_2 , a.ad_fk_postal_code_id postal_code_id, c.co_id id, c.co_name name, c.co_fk_address_id address_id, c.co_internal_reference internal_reference, c.co_message message, c.co_password password FROM s_postal_code p INNER JOIN s_address a ON a.ad_fk_postal_code_id = p.pc_id INNER JOIN s_condominium c ON c.co_fk_address_id = a.ad_id ORDER BY co_name LIMIT '.$start.', '.$limit);
        }
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $condominiums[] = new Condominium($data);
        }
        return ($condominiums);
    }
    
    public function modify($data)
    {
// echo('id condominium : '.$data['id'].'<br>');
        
        if ((is_array($data)) && (isset($data['id'])))
        {
            $condominium = $this->get($data['id']); // objet $condominium créé dans get()
            
            if ((array_key_exists('address_1', $data)) || (array_key_exists('address_2', $data)) || (array_key_exists('postal_code', $data))) // Si on veut modifier l'adresse :
            {
// echo('127            On veut modifier l\'adresse<br>');
                if (($this->_db->query('SELECT COUNT(*) FROM s_condominium WHERE co_fk_address_id = '. $condominium->address_id())->fetchColumn() >= 2) || ($this->_db->query('SELECT COUNT(*) FROM s_general_assembly WHERE ga_fk_address_id = '. $condominium->address_id())->fetchColumn() >= 1)) // Si l'adresse est utilisée ailleurs :
                {
  // Mais existe-t-il déjà une adresse avec ces nouveaux attributs ?
                    // 1) Récupérer l'id du code postal.
                    if (array_key_exists('postal_code', $data)) // Si on change postal_code, city ou line_5 :
                    {
                        $postal_code_manager = new Postal_codeManager($this->_db);

                        $param_pc['postal_code'] = $data['postal_code'];
                        $param_pc['city'] = (array_key_exists('city', $data)) ? $data['city'] : $condominium->city();
                        $param_pc['line_5'] = (array_key_exists('line_5', $data)) ? $data['line_5'] : $condominium->line_5();

                        $postal_code = new Postal_code($param_pc);

                        $postal_code_id = $postal_code_manager->getId($param_pc);
// echo('143             Id code postal récupéré : ' . $postal_code_id . '<br>');
                    }
                    else // Le code postal n'est pas transmis : le changement est sur address_1 ou address_2
                    {
                        $postal_code_id = $condominium->postal_code_id();
                    }
                    // 2) Chercher si la nouvelles adresse existe déjà, récupérer son id. 
                    $address_manager = new AddressManager($this->_db);
                    $param_ad['part_1'] = (array_key_exists('address_1', $data)) ? $data['address_1'] : $condominium->address_1();
                    $param_ad['part_2'] = (array_key_exists('address_2', $data)) ? $data['address_2'] : $condominium->address_2();
                    $param_ad['postal_code_id'] = $postal_code_id;
                    $address = new Address($param_ad);

                    $address_id = $address_manager->getId($param_ad);
// echo('157            Id adresse déjà existante récupérée' . $address_id . '<br>');

                    if (empty($address_id)) // Sinon, la créer, récupérer son id.
                    {
// echo('161        postal_code_id : ' . $postal_code_id);
                        $address = $address_manager->add($address);
                        $address_id = $address->id();
// echo('164            Id adresse créée' . $address_id . '<br>');
                    }
                    
                    $condominium->setAddress_id($address_id);
                    $condominium->setAddress_1($param_ad['part_1']);
                    $condominium->setAddress_2($param_ad['part_2']);
                    $condominium->setPostal_code_id($postal_code_id);
                    if (isset($param_pc['postal_code_id']))
                    {
                        $condominium->setPostal_code($param_ad['postal_code']);
                    }
                    if (isset($param_pc['city']))
                    {
                        $condominium->setCity($param_pc['city']);
                    }
                    if (isset($param_pc['line_5']))
                    {
                        $condominium->setLine_5($param_pc['line_5']);
                    }
                }
                else
                {
// echo('186            Non pas d\'autre condo/ga à la meme address<br>');
                    // Est-ce qu'une adresse existe déjà avec les attributs de la nouvelle adresse ?
                        // Si oui, adopter son ID
                        // Si non, mondifier notre adresse
                    
                    if (array_key_exists('postal_code', $data)) // Si on change postal_code, city ou line_5 :
                    {
                        $postal_code_manager = new Postal_codeManager($this->_db);

                        $param_pc['postal_code'] = $data['postal_code'];
                        $param_pc['city'] = (array_key_exists('city', $data)) ? $data['city'] : $condominium->city();
                        $param_pc['line_5'] = (array_key_exists('line_5', $data)) ? $data['line_5'] : $condominium->line_5();

                        $postal_code = new Postal_code($param_pc);

                        $postal_code_id = $postal_code_manager->getId($param_pc);
// echo('202            Id code postal récupéré : ' . $postal_code_id . '<br>');
                    }
                    else // Le code postal n'est pas transmis : le changement est sur address_1 ou address_2
                    {
                        $postal_code_id = $condominium->postal_code_id();
                    }
                    // 2) Chercher si la nouvelle adresse existe déjà, récupérer son id. 
                    $address_manager = new AddressManager($this->_db);
                    $param_ad['part_1'] = (array_key_exists('address_1', $data)) ? $data['address_1'] : $condominium->address_1();
                    $param_ad['part_2'] = (array_key_exists('address_2', $data)) ? $data['address_2'] : $condominium->address_2();
                    $param_ad['postal_code_id'] = $postal_code_id;
                    
                    
                    $address_id = $address_manager->getId($param_ad);
                    
                    if (empty($address_id)) // Sinon, modifier les attributs de l'adresse
                    {
                        $address_id = $condominium->address_id();
                        $param_ad['id'] = $condominium->address_id();
                        $address = new Address($param_ad);
                        $address_manager->update($address);
// echo('223               Id adresse modifiée' . $address_id . '<br>          ');
                    }
                    else
                    {
// echo('227               Id adresse déjà existante récupérée' . $address_id . '<br>');                        
                    }
                    $condominium->setAddress_id($address_id);
                    $condominium->setAddress_1($param_ad['part_1']);
                    $condominium->setAddress_2($param_ad['part_2']);
                    $condominium->setPostal_code_id($postal_code_id);
                    if (isset($param_pc['postal_code']))
                    {
                        $condominium->setPostal_code($param_pc['postal_code']);
//echo('236 postalcode : ' . $condominium->postal_code());
                    }
                    if (isset($param_pc['city']))
                    {
                        $condominium->setCity($param_pc['city']);
                    }
                    if (isset($param_pc['line_5']))
                    {
                        $condominium->setLine_5($param_pc['line_5']);
                    }
                }
            }
            else
            {
// echo('249            On ne veut pas modifier l\'adresse<br>          ');
                foreach($data as $key => $value)
                {
                    if ($key != 'id')
                    {
// echo '255              CondominiumManager.php - $key : ' . $key . 'et $value : ' . $value .'<br>           ';
                        $method = 'set'.ucfirst($key);
                        if (method_exists($condominium, $method))
                        {
                            $condominium->$method($value);
                        }
                    }
                }
            }
                
        }
        $this->update($condominium);
        return $condominium;
    }

    function save($condominium)
    {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function update($condominium)
    {
        $q = $this->_db->prepare('UPDATE s_condominium SET co_name = :name, co_fk_address_id = :address_id, co_internal_reference = :internal_reference, co_password = :password, co_message = :message WHERE co_id = :id');
        $q->bindValue(':name', $condominium->name());
        $q->bindValue(':address_id', $condominium->address_id());
        $q->bindValue(':internal_reference', $condominium->internal_reference());
        $q->bindValue(':password', $condominium->password());
        $q->bindValue(':message', $condominium->message());
        $q->bindValue(':id', $condominium->id());
        $q->execute();
        return($condominium);
    }

    public function valid($name, $password)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_condominium WHERE co_name = :co_name AND co_password = :co_password');
        $q->bindValue(':co_name', $name);
        $q->bindValue(':co_password', $password);
        $q->execute();
        
        return (bool) $q->fetchColumn(); 
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}

?>
