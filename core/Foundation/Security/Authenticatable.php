<?php
namespace Apricot\Foundation\Security;

/**
 * Authenticatable interface
 */
interface Authenticatable
{
    /**
     * Gets the authentication name.
     *
     * @return string
     */
    public function getAuthName():string;

    /**
     * Authenticates the user.
     *
     * @param string $account
     * @param string $password
     * @return object|bool return object if authenticated, else return false
     */
    public function authenticateUser(string $account, string $password);

    /**
     * Remembers the user.
     *
     * @param string $remenber_token
     * @return object|bool return object if authenticated, else return false
     */
    public function rememberUser(string $remenber_token);

    /**
     * Retrieves the user.
     *
     * @param object $user
     * @return object|bool return object if success, else return false
     */
    public function retrieveUser(object $user);

    /**
     * Saves the remember_token.
     *
     * @param object $user
     * @param string $remenber_token
     * @return bool|bool return true if success, else return false
     */
    public function saveRemenberToken(object $user, string $remenber_token):bool;
}