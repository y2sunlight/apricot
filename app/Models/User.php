<?php
namespace App\Models;

use App\Foundation\Model;
use ORM;
use Core\Foundation\Security\Authenticatable;
use App\Foundation\Security\AuthTrait;

/**
 * ユーザモデル
 */
class User extends Model implements Authenticatable
{
    /**
     * Authenticatable User
     * Includeing default implementation of Authenticatable
     */
    use AuthTrait;

    /**
     * ユーザ新規保存
     * {@inheritDoc}
     * @see \App\Foundation\Model::insert()
     */
    public function insert(array $inputs):ORM
    {
        // 新規登録時、パスワードは必須
        // パスワード暗号化
        $inputs['password'] = password_hash($inputs['password'], PASSWORD_DEFAULT);

        // 新規保存
        return parent::insert($inputs);
    }

    /**
     * ユーザデータ更新
     * {@inheritDoc}
     * @see \App\Foundation\Model::update()
     */
    public function update($id, array $inputs):ORM
    {
        // データ更新時、パスワードは入力した場合のみ変更
        if(empty($inputs['password'])) unset($inputs['password']);

        // パスワード暗号化
        if(array_key_exists('password', $inputs))
        {
            $inputs['password'] = password_hash($inputs['password'], PASSWORD_DEFAULT);
        }

        // データ更新
        return parent::update($id, $inputs);
    }
}
