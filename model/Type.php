<?php
require_once 'Document.php';

class Type {

    private $_id;
    private $_name;

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
    public function name() { return $this->_name; }
    
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }
    public function setName($name)
    {
        if (is_string($name))
        {
            $this->_name = $name;
        }
    }
}

?>
