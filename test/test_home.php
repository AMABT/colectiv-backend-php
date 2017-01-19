<?php

include_once 'TestClass.php';
include_once 'assert.php';
include_once CONTROLLER_FOLDER . 'HomeController.php';
include_once MODEL_FOLDER . 'User.php';

class HomeTest implements TestClass
{

    /* @var HomeController */
    protected $ctrl;

    public function run()
    {
        // init dummy variables
        $this->ctrl = new HomeController();

        $this->testLogin();

        echo "Home  OK\n";
    }

    protected function testLogin()
    {
        $token = AuthService::generateToken(1, 'test', 'test');
        $logged = $this->ctrl->checkLogged(true, Role::User, $token);
        assert_equal($logged, true);

        $token = AuthService::generateToken(2, 'test', 'test');
        $logged = $this->ctrl->checkLogged(true, Role::User, $token);
        assert_equal($logged, false);
    }
}