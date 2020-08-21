<?php
namespace App\Foundation\Security;

use ORM;
use Apricot\Log;

/**
 * Includeing default implementation of Authenticatable interface.
 */
trait AuthTrait
{
    /**
     * Gets the authentication name.
     * {@inheritDoc}
     * @see \Apricot\Foundation\Security\Authenticatable::getAuthName()
     */
    public function getAuthName(): string
    {
        return $this->tableName();
    }

    /**
     * Authenticates the user.
     * {@inheritDoc}
     * @see \Apricot\Foundation\Security\Authenticatable::authenticateUser()
     */
    public function authenticateUser(string $account, string $password)
    {
        $table = $this->getAuthName();
        $user = ORM::forTable($table)
        ->where([app("auth.db.{$table}.account")=>$account])
        ->findOne();

        if (($user!==false) && (password_verify($password, $user->as_array()[app("auth.db.{$table}.password")])))
        {
            Log::notice("authenticate",[$account]);
            return $user;
        }

        return false;
    }

    /**
     * Remembers the user.
     * {@inheritDoc}
     * @see \Apricot\Foundation\Security\Authenticatable::rememberUser()
     */
    public function rememberUser(string $remenber_token)
    {
        $table = $this->getAuthName();
        $user = ORM::forTable($table)
        ->where([app("auth.db.{$table}.remember")=>$remenber_token])
        ->findOne();

        if (($user!==false))
        {
            Log::notice("remember",[$user->as_array()[app("auth.db.{$table}.account")]]);
            return $user;
        }

        return false;
    }

    /**
     * Retrieves the user.
     * {@inheritDoc}
     * @see \Apricot\Foundation\Security\Authenticatable::retrieveUser()
     */
    public function retrieveUser(object $user)
    {
        $table = $this->getAuthName();
        $new_user = ORM::forTable($table)
        ->where('account',$user->as_array()[app("auth.db.{$table}.account")])
        ->findOne();

        return $new_user;
    }

    /**
     * Saves the remember_token.
     * {@inheritDoc}
     * @see \Apricot\Foundation\Security\Authenticatable::saveRemenberToken()
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
