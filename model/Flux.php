<?php

class FluxStatus
{

    const New = 'new';
    const Pending = 'pending';
    const Approved = 'approved';
    const Rejected = 'rejected';
}

class Flux
{
    /**
     * With PDO driver, the constructor will be called AFTER the object variables are set
     */

    protected $id;

    protected $name;

    protected $description;

    protected $id_user_init;

    protected $id_role_current;

    protected $created_at;

    protected $status;

    /**
     * Flow constructor.
     * @param $name
     * @param $description
     * @param $id_user_init
     * @param $id_role_current
     * @param string $status
     */
    public function __construct($name = null, $description = null, $id_user_init = null, $id_role_current = null, $status = FluxStatus::New)
    {
        if ($name !== null) {
            $this->name = $name;
            $this->description = $description;
            $this->id_user_init = $id_user_init;
            $this->id_role_current = $id_role_current;
            $this->created_at = date("Y-m-d H:i:s");
            $this->status = $status;
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
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getIdUserInit()
    {
        return $this->id_user_init;
    }

    /**
     * @param null $id_user_init
     */
    public function setIdUserInit($id_user_init)
    {
        $this->id_user_init = $id_user_init;
    }

    /**
     * @return null
     */
    public function getIdRoleCurrent()
    {
        return $this->id_role_current;
    }

    /**
     * @param null $id_role_current
     */
    public function setIdRoleCurrent($id_role_current)
    {
        $this->id_role_current = $id_role_current;
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

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            //'id_user_init' => $this->getIdUserInit(),
            //'id_role_current' => $this->getIdRoleCurrent(),
            'created_at' => $this->getCreatedAt(),
            'status' => $this->getStatus()
        );
    }


}