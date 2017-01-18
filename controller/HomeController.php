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

        $user = $this->usersRepo->getUserByNamePassword($users[0]->getName(), $users[0]->getName());
        echo '<pre>';
        var_dump($user);
    }

    public function userAction($user, $pass)
    {
        var_dump($user, $pass);
        die();
    }

    public function loginAction()
    {

        //if ($this->requestMethod() == 'POST') {

        $request = $this->request();

        var_dump($request);

        //$user = $this->usersRepo->getUserByNamePassword($user, $pass);

        //return $this->response($user->toArray());
//        }
//
//        return $this->response("Method not implemented");
    }

}