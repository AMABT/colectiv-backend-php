<?php

include_once REPOSITORY_FOLDER . 'UserRepository.php';

/**
 * Static controller for users not logged in
 */
class HomeController extends BaseController
{

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
        $usersRepo = new UserRepository();

        $users = $usersRepo->getUsers();

        $user = $usersRepo->getUserByNamePassword($users[0]->getName(), $users[0]->getName());
        echo '<pre>';
        var_dump($user);
    }

}