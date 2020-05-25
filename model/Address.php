<?php
require_once 'Condominium.php';

class Address {
    
    private $_id;
    private $_part_1 = null;
    private $_part_2 = null;
    private $_postal_code_id;

    
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
    public function id() { return $this->_id; }
    public function part_1() { return $this->_part_1; }
    public function part_2() { return $this->_part_2; }
    public function postal_code_id() { return $this->_postal_code_id; }

    public function setId($id) {
         $id = (int) $id;
        if ($id > 0)
        {
            $this->_id = $id;
        }
   }
    public function setPart_1($part_1) {
        if (is_string($part_1)) {
            $this->_part_1 = $part_1;
        }
    }
    public function setPart_2($part_2) {
        if (is_string($part_2)) {
            $this->_part_2 = $part_2;
        }
    }
    public function setPostal_code_id($postal_code_id) {
        if (is_string($postal_code_id)) {
            $this->_postal_code_id = $postal_code_id;
        }
    }
}

?>
