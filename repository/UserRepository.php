<?php

include_once MODEL_FOLDER . 'User.php';

class UserRepository
{

    protected $dbService;
    protected $userClassName = 'User';

    public function __construct()
    {
        $this->dbService = DBService::getInstance();
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {

        return $this->dbService->select("select * from users", $this->userClassName);
    }

    /**
     * @param $name
     * @param $password
     * @return User
     * @throws Exception
     */
    public function getUserByNamePassword($name, $password)
    {
        $password = md5($password);

        $users = $this->dbService->select("select * from users where name = ? and password = ?", $this->userClassName, array($name, $password));

        if (count($users) == 0) {
            throw new Exception("User not found");
        }

        return $users[0];
    }

    /**
     * @param $userId
     * @return User
     * @throws Exception
     */
    public function getUserById($userId)
    {
        $users = $this->dbService->select("select * from users where id = ?", $this->userClassName, array($userId));

        if (count($users) == 0) {
            throw new Exception("User not found");
        }

        return $users[0];

    }

}