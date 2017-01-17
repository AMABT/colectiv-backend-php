<?php

include_once MODEL_FOLDER . 'User.php';

/**
 * Abstract BaseController
 *
 */
abstract class BaseController
{

    protected $user = null;

    /**
     * If user is not logged in or current route required role is not a match, redirect to homepage
     * @param $role
     */
    public function checkLoggedAndRedirect($role)
    {
        try {
            /* @var $user User */
            $user = unserialize(SessionService::get('User'));
            $this->user = $user;
        } catch (Exception $e) {
            $user = null;
        }

        if ($user === null || strtolower($user->getRole()) != strtolower($role)) {
            // redirect to homepage
            header('Location: ' . ConfigService::get('routes')['home']);
        }
    }

    // TODO maybe this is not the best place for this function, keep it here until login implemented
    protected function logUser(User $user)
    {
        $this->user = $user;
        SessionService::set('User', serialize($user));
    }

    protected function response($data)
    {
        if (ConfigService::getEnv('response_type') == 'json') {
            return json_encode($data);
        }

        return $data;
    }
}