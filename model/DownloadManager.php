<?php
require_once 'Download.php';

class DownloadManager {
    private $_db; // Instance de PDO
    
    public function __construct($db)
    {
        $this->setDb($db);
    }
        
    public function db() { return $this->_db; }
    

    public function add($download)
    {
        $q = $this->_db->prepare('INSERT INTO s_download(dl_e_mail_address, dl_fk_document_id) VALUES(:e_mail_address, :document_id)');
        $q->bindValue(':e_mail_address', $download->e_mail_address());
        $q->bindValue(':document_id', $download->document_id());
        $q->execute();
        $download->hydrate(['id' => $this->_db->lastInsertId()]);
        return($download);
    }
    
    public function countWithDoc($document_id)
    {
        $q = $this->_db->query('SELECT COUNT(*) FROM s_download WHERE dl_fk_document_id = ' . $document_id);
        return (int) $q->fetchColumn();
    }    
    
    public function delete($id)
    {
       $q = $this->_db->prepare('DELETE FROM s_download WHERE dl_id = ?');
       $q->execute([$id]);
       return($q->rowCount());
    }
    
    public function get($id)     {
        $q = $this->_db->prepare('SELECT dl_id id, dl_fk_document_id document_id, dl_e_mail_address e_mail_address, dl_time dl_time
        FROM s_download WHERE dl_id = :id');
        $q->bindValue(':id', $id);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $download = new Download($data);
        return($download);
    }

    public function getList($document_id, $start = -1, $limit = -1)
    {
        $downloads = [];
        if ($limit == -1)
        {
            $q = $this->_db->prepare('SELECT 
            d.dl_id id,
            d.dl_fk_document_id document_id,
            d.dl_e_mail_address e_mail_address,
            d.dl_time
            FROM s_download d 
            WHERE d.dl_fk_document_id = ' . $document_id .'
            ORDER BY d.dl_id ASC');
        }
        else
        {
            $q = $this->_db->prepare('SELECT 
            d.dl_id id,
            d.dl_fk_document_id document_id,
            d.dl_e_mail_address e_mail_address,
            d.dl_time
            FROM s_download d 
            WHERE d.dl_fk_document_id = ' . $document_id .'
            ORDER BY d.dl_id ASC LIMIT '. $start .', ' . $limit);
        }
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC))
        {
            $downloads[] = new Download($data);
        }
        return ($downloads);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}

?>
