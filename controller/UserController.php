<?php

include_once REPOSITORY_FOLDER . 'UserRepository.php';

class UsersController extends BaseController
{
    protected $usersRepo = null;

    public function __construct()
    {

        $this->usersRepo = new UserRepository();
    }

    public function createAction()
    {
        try {

            $request = $this->request();

            $user = new User($request['name'], $request['password'], $request['email'], $request['role']);

            $this->usersRepo->insert($user);

            return $this->response(array(
                'status' => 'success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse("User not found");
        }
    }

    public function get($userId)
    {
        try {

            $user = $this->usersRepo->getUserById($userId);

            return $this->response($user->toArray());

        } catch (Exception $e) {

            return $this->errorResponse("User not found");
        }
    }

    public function update($userId)
    {

        try {

            $user = $this->usersRepo->getUserById($userId);
            $request = $this->request();

            foreach ($request as $key => $val) {

                $method = 'set' . $key;

                $user->$method($val);
            }

            $this->usersRepo->update(array(
                'id' => $user->getId()
            ), $user);

            return $this->response(array(
                'status' => 'success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse("User not found");
        }
    }

    public function delete($userId)
    {

        try {

            $user = $this->usersRepo->getUserById($userId);

            $this->usersRepo->delete($user);

            return $this->response(array(
                'status' => 'success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse("User not found");
        }
    }
}