<?php

include_once MODEL_FOLDER . 'User.php';

class UserRepository extends AbstractRepository
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

    public function insert($data = array())
    {
        $cols = implode(", ", array_keys($data));
        $values = array();
        foreach ($data as $v) {
            $values[] = '?';
        }
        $values = implode(', ', $values);

        $sql = "insert into users ($cols) values ($values)";

        $this->dbService->insert($sql, array_values($data));
    }

    /**
     * @param $role string
     * @return integer
     * @throws Exception
     */
    public function getRoleParentId($role)
    {
        return $this->getRole($role)['id_parent'];
    }

    /**
     * @param $role string
     * @return integer
     * @throws Exception
     */
    public function getRoleId($role)
    {
        return $this->getRole($role)['id'];
    }

    /**
     * @param $name string
     * @return array
     * @throws Exception
     */
    public function getRole($name)
    {
        $query = "select * from roles where name = ?";
        $role = $this->dbService->select($query, null, array($name));

        if (count($role) == 0) {
            throw new Exception("Role not found");
        }

        return $role[0];
    }

    public function getRoleById($roleId)
    {
        $query = "select * from roles where id = ?";
        $role = $this->dbService->select($query, null, array($roleId));

        if (count($role) == 0) {
            throw new Exception("Role not found");
        }

        return $role[0];
    }

    /**
     * @param array $filter
     * @return User[]
     * @throws Exception
     */
    public function get($filter = array())
    {
        $where = self::whereToString($filter);

        $query = "select users.id, users.username, users.password, users.email, roles.name role from users left join roles on users.id_role = roles.id " . $where;
        $users = $this->dbService->select($query, $this->userClassName, array_values($filter));

        if (count($users) == 0) {
            throw new Exception("User/users not found");
        }

        return $users;
    }

    public function update($where = array(), $data = array())
    {
        $where = self::whereToString($where);
        $update = self::updateToString($data);

        $query = "update users set " . $update . " " . $where;

        return $this->dbService->update($query);
    }

    public function delete($where = array())
    {
        if (empty($where)) {
            throw new Exception("Where clause empty, can't delete all users");
        }

        $where = self::whereToString($where);

        $query = "delete from users " . $where;

        return $this->dbService->delete($query);
    }
}