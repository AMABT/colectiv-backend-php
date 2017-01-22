<?php

include_once REPOSITORY_FOLDER . 'UserRepository.php';

/**
 * Static controller for users not logged in
 */
class HomeController extends BaseController
{

    protected $usersRepo = null;

    public function __construct()
    {

        $this->usersRepo = new UserRepository();
    }

    /**
     * page must end with the word "Action"
     */
    public function homeAction()
    {
        return $this->response("It's working " . ConfigService::getEnv('base_url'));
    }

    public function helloAction($value = 'world', $name = 'fain')
    {
        return $this->response('Hello ' . $value . ' ' . $name);
    }

    public function getUsersAction()
    {

        $users = $this->usersRepo->getUsers();

//        $user = $this->usersRepo->getUserByNamePassword($users[0]->getName(), $users[0]->getName());
//        echo '<pre>';
//        var_dump($user);

        $rUsers = array();
        foreach ($users as $user) {
            $rUsers[] = $user->toArray();
        }
        return $this->response($rUsers);
    }

    public function userAction($user, $pass)
    {
        var_dump($user, $pass);
        die();
    }

    public function loginAction()
    {
        $request = $this->request();

        try {
            $user = $this->usersRepo->getUserByNamePassword($request['username'], $request['password']);

            $this->authorize($user->getId(), $user->getName());

            return $this->response($user->toArray());
        } catch (Exception $e) {
            return $this->errorResponse("User not found");
        }

    }

}