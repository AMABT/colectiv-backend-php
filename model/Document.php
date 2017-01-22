<?php

class Document
{
    /**
     * With PDO driver, the constructor will be called AFTER the object variables are set
     */

    protected $id;

    protected $id_user;

    protected $name;

    protected $location;

    protected $created_at;

    /**
     * Document constructor.
     * @param $id_user
     * @param $name
     * @param $location
     */
    public function __construct($id_user = null, $name = null, $location = null)
    {
        if ($id_user !== null) {
            $this->id_user = $id_user;
            $this->name = $name;
            $this->location = $location;
            $this->created_at = date("Y-m-d H:i:s");
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return false|string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param false|string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt()
        );
    }

}

