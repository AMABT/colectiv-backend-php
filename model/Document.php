<?php
class Status
{

    const Draft = 'DRAFT';
    const Finals = 'FINAL';
    const Finalr = 'FINAL REVIZUIT';
    const Locked = 'BLOCAT';
}

class Document
{
    /**
     * With PDO driver, the constructor will be called AFTER the object variables are set
     */

    protected $id;

    protected $id_user;

    protected $name;

    protected $location;

    protected $status;

    protected $version;

    protected $created_at;

    /**
     * Document constructor.
     * @param $id_user
     * @param $name
     * @param $location
     */
    public function __construct($id_user, $name, $location)
    {
        $this->id_user = $id_user;
        $this->name = $name;
        $this->location = $location;
        $this->status = Status::Draft;
        $this->version = 1;
        $this->created_at = date("d-m-Y");
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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
        /**
     * @return mixed
     */

}

