<?php
namespace App\Models;

use App\Foundation\Model;
use ORM;
use Apricot\Foundation\Security\Authenticatable;
use App\Foundation\Security\AuthTrait;

/**
 * User Model
 */
class User extends Model implements Authenticatable
{
    /**
     * Includeing default implementation of Authenticatable interface.
     */
    use AuthTrait;

    /**
     * {@inheritDoc}
     * @see \App\Foundation\Model::insert()
     */
    public function insert(array $inputs):ORM
    {
        // Encrypt the password that is required for new registration.
        $inputs['password'] = password_hash($inputs['password'], PASSWORD_DEFAULT);

        return parent::insert($inputs);
    }

    /**
     * {@inheritDoc}
     * @see \App\Foundation\Model::update()
     */
    public function update($id, array $inputs):ORM
    {
        // Change password only if entered.
        if(empty($inputs['password'])) unset($inputs['password']);

        // Encrypt the password
        if(array_key_exists('password', $inputs))
        {
            $inputs['password'] = password_hash($inputs['password'], PASSWORD_DEFAULT);
        }

        return parent::update($id, $inputs);
    }
}
