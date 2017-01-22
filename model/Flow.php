<?php
class FlowStatus
{

    const New = 'NEW';
    const Pending = 'PENDING';
    const Approved = 'APPROVED';
    const Rejected = 'REJECTED';
}
/**
 * Created by PhpStorm.
 * User: AlexandraTu
 * Date: 1/17/2017
 * Time: 10:14 PM
 */

class Flow
{
    /**
     * With PDO driver, the constructor will be called AFTER the object variables are set
     */

    protected $id;

    protected $name;

    protected $description;

    protected $id_user_init;

    protected $id_user_current;

    protected $created_at;

    protected $status;

    /**
     * Flow constructor.
     * @param $name
     * @param $description
     * @param $id_user_init
     * @param $id_user_current
     */
    public function __construct($name, $description, $id_user_init, $id_user_current)
    {
        $this->name = $name;
        $this->description = $description;
        $this->id_user_init = $id_user_init;
        $this->id_user_current = $id_user_current;
        $this->created_at = date("d-m-Y");
        $this->status = FlowStatus::New;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIdUserInit()
    {
        return $this->id_user_init;
    }

    /**
     * @param mixed $id_user_init
     */
    public function setIdUserInit($id_user_init)
    {
        $this->id_user_init = $id_user_init;
    }

    /**
     * @return mixed
     */
    public function getIdUserCurrent()
    {
        return $this->id_user_current;
    }

    /**
     * @param mixed $id_user_current
     */
    public function setIdUserCurrent($id_user_current)
    {
        $this->id_user_current = $id_user_current;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
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


}