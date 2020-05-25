<?php
require_once 'General_assembly.php';

class General_assemblyManager {

    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
    
    public function db() { return $this->_db; }


    public function add($general_assembly)
    {
/*        echo('Add<pre>');
        var_dump($general_assembly);
        echo('</pre>');
        */
        if (!is_null($general_assembly->postal_code()) && $general_assembly->postal_code() != '')
        {
            // 1) Récupérer l'id du code postal.
            $postal_code_manager = new Postal_codeManager($this->_db);
            $param_pc['postal_code'] = $general_assembly->postal_code();
            $param_pc['city'] = $general_assembly->city();
            $param_pc['line_5'] = $general_assembly->line_5();
            $postal_code = new Postal_code($param_pc);
            $postal_code_id = $postal_code_manager->getId($param_pc);

            // 2) Chercher si l'adresse existe déjà, récupérer son id. 
            $address_manager = new AddressManager($this->_db);
            $param_ad['part_1'] = $general_assembly->address_1();
            $param_ad['part_2'] = $general_assembly->address_2();
            $param_ad['postal_code_id'] = $postal_code_id;
            $address = new Address($param_ad);

            $address_id = $address_manager->getId($param_ad);

            if (empty($address_id)) // Sinon, la créer, récupérer son id.
            {
                $address = $address_manager->add($address);
                $address_id = $address->id();
            }                
            $condominiumManager = new CondominiumManager($this->_db);
            $condominium = $condominiumManager->get($general_assembly->condominium_id());
            // 3) Créer la nouvelle assemblé générale.
            $q = $this->_db->prepare('INSERT INTO 
            s_general_assembly(ga_fk_condominium_id, ga_webinar_url, ga_room, ga_time, ga_fk_address_id) VALUES(:condominium_id, :webinar_url, :room, :ga_time, :address_id)');
            $q->bindValue(':condominium_id', $general_assembly->condominium_id());
            $q->bindValue(':webinar_url', $general_assembly->webinar_url());
            $q->bindValue(':room', $general_assembly->room());
            $q->bindValue(':ga_time', $general_assembly->ga_time());
            $q->bindValue(':address_id', $address_id);
            $q->execute();

        
        }
        else
        {
            $address_id = '';
            $postal_code_id = '';
            $condominiumManager = new CondominiumManager($this->_db);
            $condominium = $condominiumManager->get($general_assembly->condominium_id());
            // 3) Créer la nouvelle assemblé générale.
            $q = $this->_db->prepare('INSERT INTO 
            s_general_assembly(ga_fk_condominium_id, ga_webinar_url, ga_room, ga_time) VALUES(:condominium_id, :webinar_url, :room, :ga_time)');
            $q->bindValue(':condominium_id', $general_assembly->condominium_id());
            $q->bindValue(':webinar_url', $general_assembly->webinar_url());
            $q->bindValue(':room', $general_assembly->room());
            $q->bindValue(':ga_time', $general_assembly->ga_time());
            $q->execute();
        }
        
        $general_assembly->hydrate([
            'id' => $this->_db->lastInsertId(),
            'address_id' =>$address_id,
            'code_postal_id' => $postal_code_id,
            'condominium_name' => $condominium->name()
         ]);
        
        return($general_assembly);
        
    }
    function count()     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }

    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_general_assembly WHERE ga_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }

    public function countAddress_id($address_id)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM s_general_assembly WHERE ga_fk_address_id = :address_id');
        $q->execute([':address_id' => $address_id]);
        
        return (int) $q->fetchColumn();
    }
    

    public function existsWithCondominium($condominium_id)
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_general_assembly WHERE ga_fk_condominium_id = ' . (int) $condominium_id);
        
        return (bool) $q->fetchColumn();         
    }
    
    public function get($id)
    {
        echo('<br>ga_id G_aM 106' . $id .'<br>');
        if ($this->hasAddressWithCondominium($condominium_id))
        {
            $q = $this->_db->query('SELECT
            p.pc_postal_code postal_code,
            p.pc_city city,
            p.pc_line_5 line_5,
            a.ad_part_1 address_1,
            a.ad_part_2 address_2,
            a.ad_fk_postal_code_id postal_code_id,
            c.co_name condominium_name,
            g.ga_fk_address_id address_id, 
            g.ga_fk_condominium_id, 
            g.ga_time ga_time, 
            g.ga_room room, 
            g.ga_webinar_url webinar_url 
            FROM s_postal_code p INNER JOIN s_address a 
            ON a.ad_fk_postal_code_id = p.pc_id 
            INNER JOIN s_general_assembly g 
            ON g.ga_fk_address_id = a.ad_id 
            INNER JOIN s_condominium c 
            ON g.ga_fk_condominium_id = c.co_id 
            WHERE g.ga_id = ' . $id);
        }
        else
        {
            $q = $this->_db->query('SELECT
            c.co_name condominium_name,
            g.ga_fk_condominium_id, 
            g.ga_time ga_time, 
            g.ga_room room, 
            g.ga_webinar_url webinar_url 
            FROM s_condominium c 
            INNER JOIN s_general_assembly g 
            ON g.ga_fk_condominium_id = c.co_id 
            WHERE g.ga_id = ' . $id);            
        }
        $data = $q->fetch(PDO::FETCH_ASSOC);
        echo('Get 144<pre>');
        var_dump($data);
        echo('</pre>'); 
        
        return new General_assembly($data);
    }
    
    public function getWithCondominium($condominium_id)
    {
        if ($this->hasAddressWithCondominium($condominium_id))
        {
            $q = $this->_db->query('SELECT 
            p.pc_postal_code postal_code, 
            p.pc_city city, 
            p.pc_line_5 line_5, 
            a.ad_part_1 address_1, 
            a.ad_part_2 address_2, 
            a.ad_fk_postal_code_id postal_code_id, 
            c.co_name condominium_name, 
            g.ga_fk_address_id address_id, 
            g.ga_fk_condominium_id condominium_id, 
            g.ga_time ga_time, 
            g.ga_webinar_url webinar_url, 
            g.ga_room room,
            g.ga_id id
            FROM s_postal_code p 
            INNER JOIN s_address a 
            ON a.ad_fk_postal_code_id = p.pc_id 
            INNER JOIN s_general_assembly g 
            ON g.ga_fk_address_id = a.ad_id 
            INNER JOIN s_condominium c 
            ON c.co_id = g.ga_fk_condominium_id 
            WHERE g.ga_fk_condominium_id = ' . $condominium_id);            
        }
        else
        {
            $q = $this->_db->query('SELECT 
            c.co_name condominium_name, 
            g.ga_fk_address_id address_id, 
            g.ga_fk_condominium_id condominium_id, 
            g.ga_time ga_time, 
            g.ga_webinar_url webinar_url, 
            g.ga_room room,
            g.ga_id id
            FROM s_condominium c 
            INNER JOIN s_general_assembly g 
            ON c.co_id = g.ga_fk_condominium_id 
            WHERE g.ga_fk_condominium_id = ' . $condominium_id);
        }
        $data = $q->fetch(PDO::FETCH_ASSOC);
        if ($data)
        {
            return new General_assembly($data);
        }
        else
        {
            return FALSE;
        }
    }
    
    function getList($start, $limit)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    public function hasAddressWithCondominium($condominium_id)
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_general_assembly WHERE ga_fk_condominium_id = ' . (int) $condominium_id . ' AND ga_fk_address_id IS NOT NULL');
        return (bool) $q->fetchColumn();
    }
    
    function save($general_assembly)     {
        trigger_error('Not Implemented!', E_USER_WARNING);
    }
    
    public function update($general_assembly)
    {
/*        echo('Update 163<pre>');
        var_dump($general_assembly);
        echo('</pre>'); 
        */
        if (!is_null($general_assembly->postal_code()) && $general_assembly->postal_code() != '')
        {
            // 1) Récupérer l'id du code postal.
            $postal_code_manager = new Postal_codeManager($this->_db);
            $param_pc['postal_code'] = $general_assembly->postal_code();
            $param_pc['city'] = $general_assembly->city();
            $param_pc['line_5'] = $general_assembly->line_5();
            $postal_code = new Postal_code($param_pc);
            $postal_code_id = $postal_code_manager->getId($param_pc);

            // 2) Chercher si l'adresse existe déjà, récupérer son id. 
            $address_manager = new AddressManager($this->_db);
            $param_ad['part_1'] = $general_assembly->address_1();
            $param_ad['part_2'] = $general_assembly->address_2();
            $param_ad['postal_code_id'] = $postal_code_id;
            $address = new Address($param_ad);

            $address_id = $address_manager->getId($param_ad);

            if (empty($address_id)) // Sinon, la créer, récupérer son id.
            {
                $address = $address_manager->add($address);
                $address_id = $address->id();
            }                
        }
        else
        {
            $address_id = NULL;
            $postal_code_id = '';
        }
        
        $condominiumManager = new CondominiumManager($this->_db);
        $condominium = $condominiumManager->get($general_assembly->condominium_id());

/*        echo('Update 258<pre>');
        var_dump($general_assembly);
        echo('</pre>'); 
*/
        $q = $this->_db->prepare('UPDATE s_general_assembly SET ga_fk_condominium_id = :condominium_id, ga_webinar_url = :webinar_url, ga_room = :room, ga_time = :ga_time, ga_fk_address_id = :address_id WHERE ga_id = :id');
        $q->bindValue(':condominium_id', $general_assembly->condominium_id());
        $q->bindValue(':webinar_url', $general_assembly->webinar_url());
        $q->bindValue(':room', $general_assembly->room());
        $q->bindValue(':ga_time', $general_assembly->ga_time());
        $q->bindValue(':address_id', $address_id);
        $q->bindValue(':id', $general_assembly->id());
        $q->execute();
        
        $general_assembly->hydrate([
            'id' => $this->_db->lastInsertId(),
            'address_id' =>$address_id,
            'code_postal_id' => $postal_code_id,
            'condominium_name' => $condominium->name()
         ]);
        /*
        echo('Update 220<pre>');
        var_dump($general_assembly);
        echo('</pre>'); 
        */
        return($general_assembly);
        
    }
    
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}

?>
