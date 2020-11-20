<?php

class General_assembly {

    private $_id;
    private $_address_id;
    private $_address_1;
    private $_address_2;
    private $_postal_code_id;
    private $_postal_code;
    private $_city;
    private $_line_5;
    private $_condominium_id;
    private $_condominium_name;
    private $_ga_time;
    private $_webinar_url;
    private $_room;
    
	//Adresses des lieu de réunion pour les assemblées générales
    const NAME_1 = 'Salle en location';
    const ADDRESS_1_1 = '12, place de l\'église';
    const ADDRESS_2_1 = NULL;
    const POSTAL_CODE_1 = '69006';
    const CITY_1 = 'LYON';
    const NAME_2 = 'Salle du siège';    
    const ADDRESS_1_2 = '102, rue des Vendanges';
    const ADDRESS_2_2 = NULL;
    const POSTAL_CODE_2 = '69006';
    const CITY_2 = 'LYON'; 

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
    public function address_id() { return $this->_address_id; }
    public function address_1() { return $this->_address_1; }
    public function address_2() { return $this->_address_2; }
    public function postal_code_id() { return $this->_postal_code_id; }
    public function postal_code() { return $this->_postal_code; }
    public function city() { return $this->_city; }
    public function line_5() { return $this->_line_5; }
    public function condominium_id() { return $this->_condominium_id; }
    public function condominium_name() { return $this->_condominium_name; }
    public function ga_time() { return $this->_ga_time; }
    public function webinar_url() { return $this->_webinar_url; }
    public function room() { return $this->_room; }

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
            $this->_id = $id;
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
    public function setCondominium_id($condominium_id)     {
        $condominium_id = (int) $condominium_id;
        if ($condominium_id > 0)
        {
            $this->_condominium_id = $condominium_id;
        }
    }
    public function setCondominium_name($condominium_name)     {
        if (is_string($condominium_name)) {
            $this->_condominium_name = $condominium_name;
        }
    }
    public function setGa_time($ga_time)     {
        if (is_string($ga_time)) {
            $this->_ga_time = $ga_time;
        }
    }
    public function setWebinar_url($webinar_url)     {
        if (is_string($webinar_url)) {
            $this->_webinar_url = $webinar_url;
        }
    }
    public function setRoom($room)     {
        if (is_string($room)) {
            $this->_room = $room;
        }
    }
}

?>
