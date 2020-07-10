<?php
namespace Core\Foundation\Security;

/**
 * Authenticatable interface
 */
interface Authenticatable
{
    /**
     * Get authentication name
     * @return string
     */
    public function getAuthName():string;

    /**
     * Authenticate user
     * @param string $account
     * @param string $password
     * @return object|bool return object if authenticated, else return false
     */
    public function authenticateUser(string $account, string $password);

    /**
     * Remember user
     * @param string $remenber_token
     * @return object|bool return object if authenticated, else return false
     */
    public function rememberUser(string $remenber_token);

    /**
     * Retrieve user
     * @param object $user
     * @return object|bool return object if success, else return false
     */
    public function retrieveUser(object $user);

    /**
     * Save remember token
     * @param object $user
     * @return bool|bool return true if success, else return false
     */
    public function saveRemenberToken(object $user, string $remenber_token):bool;
}