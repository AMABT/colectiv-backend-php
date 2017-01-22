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
     * @param $requiredMethod
     * @param $requireLogin
     * @param null $requireRole
     * @internal param null $token
     */
    public function checkLoggedAndRedirect($requiredMethod, $requireLogin, $requireRole = null)
    {
        if (!empty($requiredMethod) && $requiredMethod != $this->requestMethod()) {
            header('HTTP/1.0 405 Method Not Allowed');
            die();
        }

        // requireLogin - check if token is valid
        if ($requireLogin) {

            // get all request headers and look for token
            $headers = getallheaders();
            $authHeaderName = ConfigService::getEnv('auth_header');

            if (!empty($headers[$authHeaderName])) {
                $this->token = trim($headers[$authHeaderName]);
            } else {

                // missing token
                header('HTTP/1.0 400 Bad Request');
                die();
            }

            if (AuthService::isTokenValid($this->token)) {

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
                header('HTTP/1.0 401 Unauthorized');
                die();
            }
        }

    }

    /**
     * Authorize user
     * @param $userId
     * @param $username
     */
    protected function authorize($userId, $username)
    {
        $this->token = AuthService::generateToken($userId, $username);
    }

    protected function response($data)
    {
        if ($this->token) {
            // set token to response header
            header(ConfigService::getEnv('auth_header') . ": " . $this->token);
        }

        if (ConfigService::getEnv('response_type') == 'json') {

            header('Content-Type: application/json');

            return json_encode($data);
        }

        return $data;
    }

    protected function errorResponse($data)
    {
        return $this->response(array(
            'error' => $data
        ));
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