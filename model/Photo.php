<?php

class Photo {

    private $_caption = NULL;
    private $_condominium_id;
    private $_condominium_name;
    private $_file_name;
    private $_id;
    private $_position = 1;

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


    public function caption() { return $this->_caption; }
    public function condominium_id() { return $this->_condominium_id; }
    public function condominium_name() { return $this->_condominium_name; }
    public function id() { return $this->_id; }
    public function file_name() { return $this->_file_name; }
    public function position() { return $this->_position; }
    
    public function setCaption($caption)
    {
        if (is_string($caption))
        {
            $this->_caption = $caption;
        }
    }

    public function setCondominium_id($condominium_id)
    {
        $condominium_id = (int) $condominium_id;
        if ($condominium_id > 0)
        {
            $this->_condominium_id = $condominium_id;
        }
    }
    public function setCondominium_name($condominium_name)
    {
        if (is_string($condominium_name))
        {
            $this->_condominium_name = $condominium_name;
        }
    }

    public function setFile_name($file_name)
    {
         if (is_string($file_name))
        {
            $this->_file_name = $file_name;
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

    public function setposition($position)
    {
        $position = (int) $position;
        if ($position > 0)
        {
            $this->_position = $position;
        }
    }
}

?>
