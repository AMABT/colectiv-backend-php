<?php

class Role
{

    const User = 'user';
    const Admin = 'admin';
    const SuperAdmin = 'superAdmin';
}

class User
{
    /**
     * With PDO driver, the constructor will be called AFTER the object variables are set
     */

    protected $id = null;

    protected $username;

    protected $password;

    protected $email;

    protected $role;

    /**
     * User constructor - THIS IS CALLED AFTER PDO init
     * @param $id
     * @param $name
     * @param $password
     * @param $email
     * @param $role
     */
    public function __construct($name = null, $password = null, $email = null, $role = null)
    {
        // if it's not called from PDO
        if ($name !== null) {
            $this->username = $name;
            $this->password = md5($password);
            $this->email = $email;
            $this->role = $role;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * This will return private variables too
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getUsername(),
            'email' => $this->getEmail(),
            'role' => $this->getRole()
        );
    }

}