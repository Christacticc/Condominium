<?php

class Download {

    private $_document_id;
    private $_e_mail_address;
    private $_id;
    private $_dl_time;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    public function document_id() { return $this->_document_id; }
    public function e_mail_address() { return $this->_e_mail_address; }
    public function id() { return $this->_id; }
    public function dl_time() { return $this->_dl_time; }

    public function setDocument_id($document_id)
    {
        $document_id = (int) $document_id;
        if ($document_id > 0)
        {
            $this->_document_id = $document_id;
        }
    }
    
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }
    public function setE_mail_address($e_mail_address)
    {
        if (is_string($e_mail_address))
        {
            $this->_e_mail_address = $e_mail_address;
        }
    }
    
    public function setDl_time($dl_time)
    {
        if (is_string($dl_time))
        {
            $this->_dl_time = $dl_time;
        }
    }
}

?>
