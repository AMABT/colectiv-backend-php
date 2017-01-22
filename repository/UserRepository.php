<?php

include_once MODEL_FOLDER . 'User.php';

class UserRepository implements AbstractRepository
{

    protected $dbService;
    protected $userClassName = 'User';

    public function __construct()
    {
        $this->dbService = DBService::getInstance();
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

        return $this->get(array(
            'username' => $name,
            'password' => $password
        ))[0];
    }

    /**
     * @param $userId
     * @return User
     * @throws Exception
     */
    public function getUserById($userId)
    {
        return $this->get(array(
            'users.id' => $userId
        ))[0];

    }

    public function create($data = array())
    {
        // TODO: Implement create() method.
    }

    /**
     * @param array $filter
     * @return User[]
     * @throws Exception
     */
    public function get($filter = array())
    {
        if (!empty($filter)) {
            $where = [];
            foreach ($filter as $key => $val) {
                $where[] = $key . ' = ? ';
            }
            $where = ' where ' . implode(' and ', $where);
        } else {
            $where = '';
        }

        $query = "select users.id, users.username, users.password, users.email, roles.name role from users left join roles on users.id_role = roles.id " . $where;
        $users = $this->dbService->select($query, $this->userClassName, array_values($filter));

        if (count($users) == 0) {
            throw new Exception("User/users not found");
        }

        return $users;
    }

    public function update($where = array(), $data = array())
    {
        // TODO: Implement update() method.
    }

    public function delete($where = array())
    {
        // TODO: Implement delete() method.
    }
}