<?php
namespace App\Foundation\Security;

use ORM;
use Core\Log;

/**
 * Authenticatable User
 * Includeing default implementation of Authenticatable
 */
trait AuthTrait
{
    /**
     * Get authentication name
     * {@inheritDoc}
     * @see \Core\Foundation\Security\Authenticatable::getAuthName()
     */
    public function getAuthName(): string
    {
        return $this->tableName();
    }

    /**
     * Authenticate user
     * {@inheritDoc}
     * @see \Core\Foundation\Security\Authenticatable::authenticateUser()
     */
    public function authenticateUser(string $account, string $password)
    {
        $table = $this->getAuthName();
        $user = ORM::for_table($table)
        ->where([app("auth.db.{$table}.account")=>$account])
        ->find_one();

        if (($user!==false) && (password_verify($password, $user->as_array()[app("auth.db.{$table}.password")])))
        {
            Log::notice("authenticate",[$account]);
            return $user;
        }

        return false;
    }

    /**
     * Remember user
     * {@inheritDoc}
     * @see \Core\Foundation\Security\Authenticatable::rememberUser()
     */
    public function rememberUser(string $remenber_token)
    {
        $table = $this->getAuthName();
        $user = ORM::for_table($table)
        ->where([app("auth.db.{$table}.remember")=>$remenber_token])
        ->find_one();

        if (($user!==false))
        {
            Log::notice("remember",[$user->as_array()[app("auth.db.{$table}.account")]]);
            return $user;
        }

        return false;
    }

    /**
     * Retrieve user
     * {@inheritDoc}
     * @see \Core\Foundation\Security\Authenticatable::retrieveUser()
     */
    public function retrieveUser(object $user)
    {
        $table = $this->getAuthName();
        $new_user = ORM::for_table($table)
        ->where('account',$user->as_array()[app("auth.db.{$table}.account")])
        ->find_one();

        return $new_user;
    }

    /**
     * Save remenber token
     * {@inheritDoc}
     * @see \Core\Foundation\Security\Authenticatable::saveRemenberToken()
     */
    public function saveRemenberToken(object $user, string $remenber_token): bool
    {
        $table = $this->getAuthName();
        $pdo = ORM::get_db();
        $sql = "update ".$table.
        " set ".app("auth.db.{$table}.remember")."=?".
        " where ".app("auth.db.{$table}.account")."=?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$remenber_token, $user->as_array()[app("auth.db.{$table}.account")]]);
    }
}