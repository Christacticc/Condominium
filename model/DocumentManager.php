<?php
require_once 'Document.php';

class DocumentManager {

    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
    
    public function db() { return $this->_db; }

    public function add($document)
    {
        $q = $this->_db->prepare('INSERT INTO s_document(do_available, do_fk_category_id, do_fk_condominium_id, do_file_name, do_name, do_tracked, do_fk_type_id) VALUES (:available, :category_id, :condominium_id, :file_name, :name, :tracked, :type_id)');
        $q->bindValue(':available', $document->available());
        $q->bindValue(':category_id', $document->category_id());
        $q->bindValue(':category_id', $document->category_id());
        $q->bindValue(':condominium_id', $document->condominium_id());
        $q->bindValue(':file_name', $document->file_name());
        $q->bindValue(':name', $document->name());
        $q->bindValue(':tracked', $document->tracked());
        $q->bindValue(':type_id', $document->type_id());
        $q->execute();
        
        $id = $this->_db->lastInsertId(); // doit être immédiatement après execute
        
        $categoryManager = new CategoryManager($this->_db);
        $category = $categoryManager->get($document->category_id());
        $condominiumManager = new CondominiumManager($this->_db);
        $condominium = $condominiumManager->get($document->condominium_id());
        $typeManager = new TypeManager($this->_db);
        $type = $typeManager->get($document->type_id());
        $document->hydrate([
//            'id' => $this->_db->lastInsertId(), // Ne fonctionne pas
            'id' => $id,
            'category_name' => $category->name(),
            'condominium_name' => $condominium->name(),
            'condominium_internal_reference' => $condominium->internal_reference(),
            'type_name' => $type->name()
        ]);
        return($document);
    }
    
    public function countWithType($type_id)
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_document WHERE do_fk_type_id = ' . (int) $type_id);
        return (int) $q->fetchColumn();
    }

    public function countWithCategory($category_id)
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_document WHERE do_fk_category_id = ' . (int) $category_id);
        return (int) $q->fetchColumn();
    }

    public function countWithCondominiumAndCategory($condominium_id, $category_id)
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_document 
        WHERE do_fk_condominium_id = ' . (int) $condominium_id . ' 
        AND do_fk_category_id = ' . (int) $category_id);
        return (int) $q->fetchColumn();
    }

   public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_document WHERE do_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }
    
    public function get($id)     {
            $q = $this->_db->query('SELECT
            t.ty_name type_name, 
            c.ca_name category_name,
            o.co_name condominium_name, 
            o.co_internal_reference condominium_internal_reference, 
            d.do_available available, 
            d.do_fk_category_id category_id, 
            d.do_fk_condominium_id condominium_id, 
            d.do_creation_time creation_time, 
            d.do_file_name file_name, 
            d.do_id id, 
            d.do_modification_time modification_time, 
            d.do_name name, 
            d.do_sort_number sort_number, 
            d.do_tracked tracked, 
            d.do_fk_type_id type_id 
            FROM s_document d 
            INNER JOIN s_type t ON d.do_fk_type_id = t.ty_id
            INNER JOIN s_category c ON d.do_fk_category_id = c.ca_id
            INNER JOIN s_condominium o ON d.do_fk_condominium_id = o.co_id
            WHERE d.do_id = ' . $id);
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return new Document($data);
        
    }
    
    public function getFiche($id)     { // Le document de type "fiche synthétique" publié le plus récent
        $q = $this->_db->prepare('SELECT
        t.ty_name type_name, 
        c.ca_name category_name,
        o.co_name condominium_name, 
        o.co_internal_reference condominium_internal_reference, 
        d.do_available available, 
        d.do_fk_category_id category_id, 
        d.do_fk_condominium_id condominium_id, 
        d.do_creation_time creation_time, 
        d.do_file_name file_name, 
        d.do_id id, 
        d.do_modification_time modification_time, 
        d.do_name name, 
        d.do_sort_number sort_number, 
        d.do_tracked tracked, 
        d.do_fk_type_id type_id 
        FROM s_document d 
        INNER JOIN s_type t ON d.do_fk_type_id = t.ty_id
        INNER JOIN s_category c ON d.do_fk_category_id = c.ca_id
        INNER JOIN s_condominium o ON d.do_fk_condominium_id = o.co_id
        WHERE do_fk_condominium_id = :condominium__id 
        AND d.do_fk_type_id = :type__id 
        AND d.do_available = ' . 1 . ' 
        ORDER BY d.do_creation_time DESC
        LIMIT 0, 1');
        $q->bindValue(':condominium__id', $id);
        $q->bindValue(':type__id', 1); // 1 est le type "fiche synthétique"
        $q->execute();
        if ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            return new Document($data);
        }
        else
        {
            return(false);
        }
    }

    public function getList($condominium_id)
    {
        $documents = [];
        $q = $this->_db->prepare('SELECT t.ty_name type_name, c.ca_name category_name, 
        o.co_name condominium_name, 
        o.co_internal_reference condominium_internal_reference, 
        d.do_available available, 
        d.do_fk_category_id category_id, 
        d.do_fk_condominium_id condominium_id, 
        d.do_creation_time creation_time, 
        d.do_file_name file_name, 
        d.do_id id, 
        d.do_modification_time modification_time, 
        d.do_name name, 
        d.do_sort_number sort_number, 
        d.do_tracked tracked, 
        d.do_fk_type_id type_id 
        FROM s_document d 
        INNER JOIN s_type t 
        ON d.do_fk_type_id = t.ty_id
        INNER JOIN s_category c 
        ON d.do_fk_category_id = c.ca_id
        INNER JOIN s_condominium o 
        ON d.do_fk_condominium_id = o.co_id
        WHERE d.do_fk_condominium_id = ' . $condominium_id .'
        ORDER BY d.do_creation_time DESC');
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $documents[] = new Document($data);
        }
        return ($documents);
    }
    
     public function getListByCategory($condominium_id, $category_id) // listes de document back condominiumView
    {
        $documents = [];
        $q = $this->_db->prepare('SELECT t.ty_name type_name, c.ca_name category_name, 
        o.co_name condominium_name, 
        o.co_internal_reference condominium_internal_reference, 
        d.do_available available, 
        d.do_fk_category_id category_id, 
        d.do_fk_condominium_id condominium_id, 
        d.do_creation_time creation_time, 
        d.do_file_name file_name, 
        d.do_id id, 
        d.do_modification_time modification_time, 
        d.do_name name, 
        d.do_sort_number sort_number, 
        d.do_tracked tracked, 
        d.do_fk_type_id type_id 
        FROM s_document d 
        INNER JOIN s_type t 
        ON d.do_fk_type_id = t.ty_id
        INNER JOIN s_category c 
        ON d.do_fk_category_id = c.ca_id
        INNER JOIN s_condominium o 
        ON d.do_fk_condominium_id = o.co_id
        WHERE d.do_fk_condominium_id = ' . $condominium_id . ' 
        AND d.do_fk_category_id = ' . $category_id . ' 
        ORDER BY d.do_creation_time DESC');
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $documents[] = new Document($data);
        }
        return ($documents);
    }
    
    public function getListExceptExcudedCategories($condominium_id, $excluded_categories)
    {
        $documents = [];
        $in  = str_repeat('?,', count($excluded_categories) - 1) . '?'; 
        
        $q = $this->_db->prepare('SELECT t.ty_name type_name, c.ca_name category_name, 
        o.co_name condominium_name, 
        o.co_internal_reference condominium_internal_reference, 
        d.do_available available, 
        d.do_fk_category_id category_id, 
        d.do_fk_condominium_id condominium_id, 
        d.do_creation_time creation_time, 
        d.do_file_name file_name, 
        d.do_id id, 
        d.do_modification_time modification_time, 
        d.do_name name, 
        d.do_sort_number sort_number, 
        d.do_tracked tracked, 
        d.do_fk_type_id type_id 
        FROM s_document d 
        INNER JOIN s_type t 
        ON d.do_fk_type_id = t.ty_id
        INNER JOIN s_category c 
        ON d.do_fk_category_id = c.ca_id
        INNER JOIN s_condominium o 
        ON d.do_fk_condominium_id = o.co_id
        WHERE d.do_fk_condominium_id = ' . $condominium_id .'
        AND c.ca_name NOT IN (' . $in . ')
        ORDER BY d.do_creation_time DESC');
        $q->execute($excluded_categories);
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $documents[] = new Document($data);
        }
        return ($documents);
    }
    
     public function getListWithCategory($condominium_id, $category_id) //listes de documents front espaceCoproView
    {
        $documents = [];
        $q = $this->_db->prepare('SELECT t.ty_name type_name, c.ca_name category_name, 
        o.co_name condominium_name, 
        o.co_internal_reference condominium_internal_reference, 
        d.do_available available, 
        d.do_fk_category_id category_id, 
        d.do_fk_condominium_id condominium_id, 
        d.do_creation_time creation_time, 
        d.do_file_name file_name, 
        d.do_id id, 
        d.do_modification_time modification_time, 
        d.do_name name, 
        d.do_sort_number sort_number, 
        d.do_tracked tracked, 
        d.do_fk_type_id type_id 
        FROM s_document d 
        INNER JOIN s_type t 
        ON d.do_fk_type_id = t.ty_id
        INNER JOIN s_category c 
        ON d.do_fk_category_id = c.ca_id
        INNER JOIN s_condominium o 
        ON d.do_fk_condominium_id = o.co_id
        WHERE d.do_fk_condominium_id = ' . $condominium_id . ' 
        AND d.do_fk_category_id = ' . $category_id . ' 
        AND d.do_fk_type_id <> :type__id 
        AND d.do_available = ' . 1 . ' 
        ORDER BY d.do_creation_time DESC');
        $q->bindValue(':type__id', 1); // 1 est le type "fiche synthétique" que l'on élimine
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $documents[] = new Document($data);
        }
        return ($documents);
    }
    
     public function getListRecent($condominium_id) // 3 plus récents documents publiés, pas de type fiche synthétique
    {
        $recent_documents = []; 
        $categoryManager = new CategoryManager($this->_db);
        $categories = $categoryManager->getList();
        foreach($categories as $category)
        {
            $q = $this->_db->prepare('SELECT
            t.ty_name type_name, 
            c.ca_name category_name,
            o.co_name condominium_name, 
            o.co_internal_reference condominium_internal_reference, 
            d.do_available available, 
            d.do_fk_category_id category_id, 
            d.do_fk_condominium_id condominium_id, 
            d.do_creation_time creation_time, 
            d.do_file_name file_name, 
            d.do_id id, 
            d.do_modification_time modification_time, 
            d.do_name name, 
            d.do_sort_number sort_number, 
            d.do_tracked tracked, 
            d.do_fk_type_id type_id 
            FROM s_document d 
            INNER JOIN s_type t ON d.do_fk_type_id = t.ty_id
            INNER JOIN s_category c ON d.do_fk_category_id = c.ca_id
            INNER JOIN s_condominium o ON d.do_fk_condominium_id = o.co_id
            WHERE do_fk_condominium_id = :condominium__id 
            AND do_fk_category_id = :category__id 
            AND d.do_fk_type_id <> :type__id 
            AND d.do_available = ' . 1 . ' 
            ORDER BY d.do_creation_time DESC
            LIMIT 0, 1');
            $q->bindValue(':condominium__id', $condominium_id);
            $q->bindValue(':category__id', $category->id());
            $q->bindValue(':type__id', 1); // 1 est le type "fiche synthétique" que l'on élimine
            $q->execute();
            if ($data = $q->fetch(PDO::FETCH_ASSOC))
            {
                $document = new Document($data);
                $recent_documents[] = new Document($data);
            }
        }
        return ($recent_documents);
    }
    
      public function getOlder($condominium_id, $category_id, $creation_time) // listes de document back condominiumView
    {
        $q = $this->_db->prepare('SELECT
        t.ty_name type_name, 
        c.ca_name category_name,
        o.co_name condominium_name, 
        o.co_internal_reference condominium_internal_reference, 
        d.do_available available, 
        d.do_fk_category_id category_id, 
        d.do_fk_condominium_id condominium_id, 
        d.do_creation_time creation_time, 
        d.do_file_name file_name, 
        d.do_id id, 
        d.do_modification_time modification_time, 
        d.do_name name, 
        d.do_sort_number sort_number, 
        d.do_tracked tracked, 
        d.do_fk_type_id type_id 
        FROM s_document d 
        INNER JOIN s_type t ON d.do_fk_type_id = t.ty_id
        INNER JOIN s_category c ON d.do_fk_category_id = c.ca_id
        INNER JOIN s_condominium o ON d.do_fk_condominium_id = o.co_id
        WHERE do_fk_condominium_id = :condominium__id 
        AND d.do_fk_category_id = :category__id 
        AND d.do_creation_time < :creation__time 
        ORDER BY d.do_creation_time DESC
        LIMIT 0, 1');
        $q->bindValue(':condominium__id', $condominium_id);
        $q->bindValue(':category__id', $category_id); 
        $q->bindValue(':creation__time', $creation_time); 
        $q->execute();
        if ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            return new Document($data);
        }
        else
        {
            return(false);
        }
    }

   public function modify($data)
    {
        if ((is_array($data)) && (isset($data['id'])))
        {
            $document = $this->get($data['id']); // objet $document créé dans get()
            foreach($data as $key => $value)
            {
                if ($key != 'id')
                {
                    $method = 'set'.ucfirst($key);
                    if (method_exists($document, $method))
                    {
                        $document->$method($value);
                    }
                }
            }
        }
        $this->update($document);
        $document = $this->get($data['id']); // pour récupérer la date de modification
        return $document;        
    }
        
    public function update($document)
    {
        $q = $this->_db->prepare('UPDATE s_document SET do_name = :name, do_fk_category_id = :category_id, do_fk_type_id = :type_id, do_available = :available, do_tracked = :tracked WHERE do_id = :id');
        $q->bindValue(':name', $document->name());
        $q->bindValue(':category_id', $document->category_id());
        $q->bindValue(':type_id', $document->type_id());
        $q->bindValue(':available', $document->available());
        $q->bindValue(':tracked', $document->tracked());
        $q->bindValue(':id', $document->id()); 
        $q->execute();
        return($document);
    }
    
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}

?>
