<?php
require_once 'Download.php';

class Document {
    
    private $_available = TRUE;
    private $_category_id;
    private $_category_name;
    private $_condominium_id;
    private $_condominium_name;
    private $_condominium_internal_reference;
    private $_creation_time;
    private $_file_name;
    private $_id;
    private $_modification_time;
    private $_name;
    private $_sort_number;
    private $_tracked = FALSE;
    private $_type_id;
    private $_type_name;

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

    public function available() { return $this->_available; }
    public function category_id() { return $this->_category_id; }
    public function category_name() { return $this->_category_name; }
    public function condominium_id() { return $this->_condominium_id; }
    public function condominium_name() { return $this->_condominium_name; }
    public function condominium_internal_reference() { return $this->_condominium_internal_reference; }
    public function creation_time() { return $this->_creation_time; }
    public function file_name() { return $this->_file_name; }
    public function id() { return $this->_id; }
    public function modification_time() { return $this->_modification_time; }
    public function name() { return $this->_name; }
    public function sort_number() { return $this->_sort_number; }
    public function tracked() { return $this->_tracked; }
    public function type_id() { return $this->_type_id; }
    public function type_name() { return $this->_type_name; }

    public function setAvailable($available)
    {
        $available = (int) $available;
        $this->_available = $available;
    }
    public function setCategory_id($category_id)
    {
        $category_id = (int) $category_id;
        if ($category_id > 0)
        {
            $this->_category_id = $category_id;
        }
    }
    public function setCategory_name($category_name)
    {
        if (is_string($category_name))
        {
            $this->_category_name = $category_name;
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
    public function setCondominium_internal_reference($condominium_internal_reference)
    {
        $condominium_internal_reference = (int) $condominium_internal_reference;
        if ($condominium_internal_reference > 0)
        {
            $this->_condominium_internal_reference = $condominium_internal_reference;
        }
    }
    public function setCreation_time($creation_time)
    {
        if (is_string($creation_time))
        {
            $this->_creation_time = $creation_time;
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
    public function setModification_time($modification_time)
    {
        if (is_string($modification_time))
        {
            $this->_modification_time = $modification_time;
        }
    }
    public function setName($name)
    {
        if (is_string($name))
        {
            $this->_name = $name;
        }
    }
    public function setSort_number($sort_number)
    {
        $sort_number = (int) $sort_number;
        if ($sort_number > 0)
        {
            $this->_sort_number = $sort_number;
        }
    }
    public function setTracked($tracked)
    {
        $tracked = (int) $tracked;
        $this->_tracked = $tracked;
    }
    public function setType_id($type_id)
    {
        $type_id = (int) $type_id;
        if ($type_id > 0)
        {
            $this->_type_id = $type_id;
        }
    }
    public function setType_name($type_name)
    {
        if (is_string($type_name))
        {
            $this->_type_name = $type_name;
        }
    }
}

?>
