<?php
require_once 'Document.php';
require_once 'General_assembly.php';

class Condominium {

    private $_id;
    private $_internal_reference;
    private $_message;
    private $_name;
    private $_password;
    private $_address_id;
    private $_address_1;
    private $_address_2;
    private $_postal_code_id;
    private $_postal_code;
    private $_city;
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
    
    public function validName()
    {
        return !empty($this->_name);
    }
    
    public function validInternal_reference()
    {
        return preg_match('#^[0-9]{6}$#', $this->_internal_reference);
    }

    public function id() { return $this->_id; }
    public function internal_reference() { return $this->_internal_reference; }
    public function message() { return $this->_message; }
    public function name() { return $this->_name; }
    public function password() { return $this->_password; }
    public function address_id() { return $this->_address_id; }
    public function address_1() { return $this->_address_1; }
    public function address_2() { return $this->_address_2; }
    public function postal_code_id() { return $this->_postal_code_id; }
    public function postal_code() { return $this->_postal_code; }
    public function city() { return $this->_city; }
    public function line_5() { return $this->_line_5; }
    
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }
    public function setInternal_reference($internal_reference)
    {
        if (is_string($internal_reference)) {
            $this->_internal_reference = $internal_reference;
        }
    }
    public function setName($name)
    {
        if (is_string($name)) {
            $this->_name = $name;
        }
    }
    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->_message = $message;
        }
    }
    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password = $password;
        }
    }
    public function setAddress_id($address_id)
    {
        $address_id = (int) $address_id;
        if ($address_id > 0)
        {
            $this->_address_id = $address_id;
        }
    }
    public function setAddress_1($address_1)
    {
        if (is_string($address_1)) {
            $this->_address_1 = $address_1;
        }
    }
    public function setAddress_2($address_2)
    {
        if (is_string($address_2)) {
            $this->_address_2 = $address_2;
        }
    }
    public function setPostal_code_id($postal_code_id)
    {
        if (is_string($postal_code_id)) {
            $this->_postal_code_id = $postal_code_id;
        }
    }
    public function setPostal_code($postal_code)
    {
        if (is_string($postal_code)) {
            $this->_postal_code = $postal_code;
        }
    }
    public function setCity($city)
    {
        if (is_string($city)) {
            $this->_city = $city;
        }
    }
    public function setLine_5($line_5)
    {
        if (is_string($line_5)) {
            $this->_line_5 = $line_5;
        }
    }
}