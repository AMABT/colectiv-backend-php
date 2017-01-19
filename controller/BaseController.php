<?php

include_once MODEL_FOLDER . 'User.php';

/**
 * Abstract BaseController
 *
 */
abstract class BaseController
{

    protected $user = null;
    private $request = null;
    private $token = null;

    /**
     * If user is not logged in or current route required role is not a match, redirect to homepage
     * @param $requireLogin
     * @param $requireRole
     * @param null $token
     * @internal param $role
     */
    public function checkLoggedAndRedirect($requireLogin, $requireRole = null, $token = null)
    {
        if (!$this->checkLogged($requireLogin, $requireRole, $token)) {
            // redirect to homepage if current user is not supposed to be here - maybe redirect to login would be better
            header('Location: ' . ConfigService::get('routes')['home']);
        }
    }

    /**
     * @param $requireLogin
     * @param null $requireRole
     * @param null $token
     * @return bool
     */
    public function checkLogged($requireLogin, $requireRole = null, $token = null)
    {
        // requireLogin - check if token is valid
        if ($requireLogin) {

            if (empty($token)) {

                // get all request headers and look for token
                $headers = getallheaders();
                $authHeaderName = ConfigService::getEnv('auth_header');

                if (!empty($headers[$authHeaderName])) {
                    $this->token = trim($headers[$authHeaderName]);
                }
            } else {
                $this->token = $token;
            }

            if (AuthService::validToken($this->token)) {

                // if token valid, get user id from token and search it in database
                $userId = AuthService::getUserIdFromToken($this->token);

                try {
                    $userRepo = new UserRepository();
                    $this->user = $userRepo->getUserById($userId);
                } catch (Exception $e) {
                    // pass
                    $this->user = null;
                }
            }

            // check if user is valid
            if ($this->user === null || ($requireRole !== null && strtolower($this->user->getRole()) != strtolower($requireRole))) {

                // redirect to homepage if current user is not supposed to be here - maybe redirect to login would be better
                return false;
            }
        }

        return true;
    }

    // TODO maybe this is not the best place for this function, keep it here until login implemented
    protected function logUser(User $user)
    {
        $this->user = $user;
        SessionService::set('User', serialize($user));
    }

    protected function response($data)
    {
        if ($this->token)
            // set token to response header
            header(ConfigService::getEnv('auth_header') . ": " . $this->token);

        if (ConfigService::getEnv('response_type') == 'json') {
            return json_encode($data);
        }

        return $data;
    }

    /**
     * Return request data
     */
    protected function request()
    {
        if ($this->request === null) {
            $inputJSON = file_get_contents('php://input');
            $this->request = json_decode($inputJSON, TRUE); //convert JSON into array
        }
        return $this->request;
    }

    /**
     * Return request method
     *
     * @return string GET | POST | PUT | DELETE
     */
    protected function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}