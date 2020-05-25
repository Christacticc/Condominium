<?php
require_once 'Address.php'; // TO DO : changer le sens de l'association ?

class Postal_code {

    private $_city;
    private $_postal_code;
    private $_id;
    private $_line_5;

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

    public function city() { return $this->_city; }
    public function postal_code() { return $this->_postal_code; }
    public function id() { return $this->_id; }
    public function line_5() { return $this->_line_5; }

    public function setCity($city)
    {
        $this->_city = $city;
    }
    public function setPostal_code($postal_code)
    {
        $this->_postal_code = $postal_code;
    }
    public function setId($id)
    {
        $this->_id = $id;
    }
    public function setLine_5($line_5)
    {
        $this->_line_5 = $line_5;
    }
}
